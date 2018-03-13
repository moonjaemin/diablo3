<?php

namespace App\Http\Controllers;

use Alert;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Diablo3\Api;
use App\Diablo3\Calc;
use App\Guild;
use App\Profile;
use Carbon\Carbon;

class D3Controller extends Controller
{
    public $className = array(
	    'barbarian'		=>'야만용사',
	    'crusader'		=>'성전사',
	    'demon-hunter'	=>'악마사냥꾼',
	    'monk'			=>'수도사',
	    'necromancer'	=>'강령술사',
	    'witch-doctor'	=>'부두술사',
	    'wizard'		=>'마법사'
	);

	public $classRank = array(
		'barbarian'     =>'야만용사',
		'crusader'      =>'성전사',
		'dh'            =>'악마사냥꾼',
		'monk'          =>'수도사',
		'necromancer'   =>'강령술사',
		'wd'            =>'부두술사',
		'wizard'        =>'마법사',
		'team-2'        =>'2인 대균열',
		'team-3'        =>'3인 대균열',
		'team-4'        =>'4인 대균열'
	);

	public $gender = array('1'=>'female', '0'=>'male');
	public $gearList = array('head','torso','feet','hands','shoulders','legs','bracers','mainHand','offHand','waist','rightFinger','leftFinger','neck');

	public $aEraIndex = array('1'=>'2014-1','2'=>'2015-1','3'=>'2015-2','4'=>'2015-3','5'=>'2015-4','6'=>'2016-1','7'=>'2016-2','8'=>'2017-1','9'=>'2017-2','10'=>'2018-1',
	'11'=>'2018-2','12'=>'2019-1','13'=>'2019-2');

    /**
     *
     *
     * @param
     * @return
     */
    public function index()
    {

        //쿠기 가져오기
        $lastBattleTags = Cookie::get('lastBattleTags');
        if(!empty($lastBattleTags))
        {
            $lastBattleTags = json_decode($lastBattleTags,true);
        }

        return view('index')->with([
            'lastBattleTags' => $lastBattleTags
        ]);
    }

    /**
     * 프로필 가져오기
     *
     * @param
     * @return
     */
    public function profile(Request $request,Api $api,$server,$battleTag)
    {

        $battleTag 	= trim(urldecode($battleTag));
        $data = array('server'=>$server, 'battleTag'=>$battleTag);
        $return = $api->get($data);

        //통신불량이거나 검색실패시 redirect 처리
        if((!empty($return['code']) && $return['code'] == 'NOTFOUND') || $return == false)
		{
            Alert::error('The account could not be found.');
            return redirect()->route("home");
		}

    	//조회된 목록 쿠키 처리
        $lastBattleTags = Cookie::get('lastBattleTags');
        $sKey = $battleTag."|".$server;

        if(!empty($lastBattleTags))
		{
			$lastBattleTags = array_reverse(json_decode($lastBattleTags,true));
			if(in_array($sKey,$lastBattleTags))
			{
				unset($lastBattleTags[array_search($sKey,$lastBattleTags)]);
			}
			$lastBattleTags[] = $sKey;
			$lastBattleTags = array_slice(array_reverse($lastBattleTags),0,10);
		}
		else {
			$lastBattleTags[] = $sKey;
		}

        //쿠키생성
        Cookie::queue('lastBattleTags', json_encode($lastBattleTags), 1440*30);

        //guildName 이 있으면 guild 번호를 가져온다
        if(!empty($return['guildName']))
        {

            $guilds = Guild::where('name', $return['guildName'])
                                ->where('server', $server)
                                ->select('id')
                                ->first();

            if(is_object($guilds))
            {
                $guildId = $guilds->id;
            }

            if(!empty($guildId))
            {
                $guildMembers = Profile::where('battle_tag','!=',$return['battleTag'])
                                        ->where('guild_id',$guildId)
                                        ->orderBy('created_at','desc')
                                        ->select('battle_tag')->paginate(10);
                //ajax 페이징 처리
                if($request->ajax())
                {
                    return view('include.members')->with([
                        'server' => $server,
                        'guildName' => (!empty($return['guildName'])) ? '&lt;'.$return['guildName'].'&gt;' : '',
                        'guildMembers' => $guildMembers
                    ]);
                }

            }
            else
            {
                $guild = new Guild;
                $guild->name = $return['guildName'];
                $guild->server = $server;
                $guild->save();

                //insert id를 가져온다
                $guildId = $guild->id;
            }
        }

        //프로필 저장
        $profiles = ['battle_tag' => $return['battleTag'],
                    'server' => $server,
                    'guild_id' => $guildId ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()];
        Profile::insertOnDuplicateKey($profiles,['guild_id','updated_at']);


        //hero목록 시즌/스텐 나누기
		$heroIds = array();
        $seasonHeroes = array();
        $heroes = array();
        $items = array();


		foreach($return['heroes'] as $hero)
		{
			$heroIds[] = $hero['id'];
			if($hero['seasonal'] == '1')
			{
				$seasonHeroes[$hero['id']]	= $hero;
			}
			else
			{
				$heroes[$hero['id']] = $hero;
			}
		}

        //전설보석 조회를 위해
		if(count($heroIds) > 0)
		{
			$returns = $api->getMulti(array('server'=>$server,'battleTag'=>$battleTag,'heroIds'=>$heroIds));
			if(!empty($returns))
			{
				foreach ($returns as $key => $val) {
					$items[$key] = $val;
				}
			}
		}

        //레퍼러 체크
        $referer = $request->headers->get('referer');

        return view('profile')->with([
            'server' => $server,
            'battleTag' => $return['battleTag'],
            'guildName' => (!empty($return['guildName'])) ? '&lt;'.$return['guildName'].'&gt;' : '',
            'paragonLevel' => number_format($return['paragonLevel']),
            'paragonLevelHardcore' => number_format($return['paragonLevelHardcore']),
            'paragonLevelSeason' => number_format($return['paragonLevelSeason']),
            'paragonLevelSeasonHardcore' => number_format($return['paragonLevelSeasonHardcore']),
            'lastUpdated' => date("Y.m.d H:i:s",$return['lastUpdated']),
            'seasonHeroes' => $seasonHeroes,
            'heroes' => $heroes,
            'items' => $items,
            'guildMembers' => $guildMembers ?? null,
            'referer' => urldecode($referer) ?? null,
        ]);
    }

    /**
     * 영웅정보
     *
     * @param
     * @return
     */
    public function hero(Request $request,Api $api,$server,$battleTag,$heroId)
    {

        $battleTag 	= trim(urldecode($battleTag));
		$data = array('server'=>$server, 'battleTag'=>$battleTag, 'heroId'=>$heroId);
        $sData = join("|",$data);
        $return = $api->get($data);

        //아이피 체크
        if($request->ip() == '125.129.25.216')
        {

        }

        //통신불량이거나 검색실패시 redirect 처리
        if((!empty($return['code']) && $return['code'] == 'OOPS') || $return == false)
        {
            Alert::error('The hero could not be found.');
            return redirect()->back();
        }


        //아이템 상세정보가져오기
        if(is_array($return['items']))
		{
			$data['items'] = 1;
			$return['items'] = $api->get($data);
		}

        //카나이
        if(is_array($return['legendaryPowers']))
		{
			$kanai = array();

			foreach ($return['legendaryPowers'] as $key => $value) {
				$kanai[$key] = $value['tooltipParams'];
			}

			$return['legendaryPowers'] = $api->getMulti(array('server'=>$server,'items'=>$kanai));
		}



        //레퍼러 체크
        $referer = $request->headers->get('referer');

        return view('hero')->with([
            'server' => $server,
            'battleTag' => $battleTag,
            'name' => $return['name'],
            'level' => $return['level'],
            'paragonLevel' => number_format($return['paragonLevel']),
            'seasonal' => $return['seasonal'],
            'gender' => $this->gender[$return['gender']],
            'class' => $return['class'],
            'className' => ($server == 'kr') ? $this->className[$return['class']] : $return['class'],
            'items' => $return['items'],
    		'skills' => $return['skills'],
    		'legendaryPowers' => $return['legendaryPowers'],
    		'stats' => $return['stats'],
    		'gearList' => $this->gearList,
    		'data' => $sData,
    		'referer' => urldecode($referer) ?? null,
        ]);
    }

    /**
     * 아이템 상세 레이어
     *
     * @param
     * @return
     */
     public function item(Request $request, Api $api)
     {
        if(empty($request->code))
        {
            return false;
        }

        list($server,$battleTag,$heroId,$gear) = explode("|", $request->code);

        $data = array('server'=>$server, 'battleTag'=>$battleTag, 'heroId'=>$heroId, 'items'=>1);
        $return = $api->get($data);

        return view('include.item')->with($return[$gear]);

     }


     /**
      * 무공계산기
      *
      * @param
      * @return
      */

      public function weapon(Request $request, Calc $calc)
      {

        if(!empty($request->weaponType) && !empty($request->weapon) && !empty($request->damageMin) && !empty($request->damageMax))
        {
            $result = $calc->weapon($request->toArray());
        }

          return view('weapon')->with(['result'=>$result ?? null]);
      }

      /**
       * 재감 계산기
       *
       * @param
       * @return
       */
       public function coolDown()
       {
           return view('cooldown');
       }

       /**
        * 순위
        *
        * @param
        * @return
        */
        public function rank(Api $api, $server, $type, $seasonal, $class, $gameType='')
        {

            $data = array('server'=>$server, 'type'=>$type, 'seasonal'=>$seasonal, 'gameType'=>$gameType, 'class'=>$class);
            $return = $api->get($data);

            if(empty($return['row']))
            {
                Alert::error('The rank data could not be found.');
                return redirect()->route('home');
            }

            $currentIndex = Storage::get('currentIndex');
            $aCurrentIndex = json_decode($currentIndex, true);


            return view('rank')->with([
                'classRank' => $this->classRank,
                'seasonCurrent' => $aCurrentIndex,
                'userList' => $return['row'],
                'type' => $type,
                'server' => $server,
                'seasonal' => $seasonal,
                'class' => $class,
                'gameType' => $gameType,
                'eraIndex' => $this->aEraIndex,
            ]);
        }


}
