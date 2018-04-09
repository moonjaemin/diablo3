<?php
namespace App\Diablo3;

use Cache;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Promise as GuzzlePromise;
use Illuminate\Support\Facades\Storage;

class Api
{
    //배틀넷 서버 목록, api key
    private $server = array('kr'=>'ko_KR','eu'=>'en_GB','us'=>'en_US');
    private $key;
    private $secret;
    private $cacheTime = 10;
    private $accessKey;


    /**
     * 생성자
     *
     * @param
     * @return
     */
    public function __construct()
    {

        $randKey    = rand(1,2);
        $this->key  = config('diablo3.key'.$randKey);
        $this->secret  = config('diablo3.secret'.$randKey);
        $json = Storage::get('accessToken');
        $aAccessToken = json_decode($json, true);
        $this->accessKey = $aAccessToken['access_token'];

    }

    public function get($data = array())
    {

        $cachekey = collect($data)->implode('|');

        if(Cache::has($cachekey)) {
            return Cache::get($cachekey);
        } else {
            $apiUrl = $this->makeUrl($data);
            if(!empty($apiUrl)) {
                $client = new Guzzle(['timeout'=>30,'http_errors'=>false]);
                $response = $client->request('GET',$apiUrl);
                if ($response->getStatusCode() == 200) {
                    $return = json_decode($response->getBody(),true);
                    Cache::put($cachekey,$return, $this->cacheTime);
                    return $return;
                }
            } else {
                return false;
            }
        }
    }

    public function getMulti($data = array())
    {

        $nodes = array();
        $res = array();
        $cachekeys = array();

        if(!empty($data['battleTag']) && !empty($data['heroIds'])) {
            foreach ($data['heroIds'] as $key => $value) {
                $cachekey = $data['battleTag']."|".$value.'|items';
                $cachekeys[$value] = $cachekey;

                if(Cache::has($cachekey)) {
                    $res[$value] = Cache::get($cachekey);
                } else {
                    $nodes[$value] = $this->makeUrl(array('server'=>$data['server'],'battleTag'=>$data['battleTag'],'heroId'=>$value,'items'=>1));
                }
            }
        } else if(!empty($data['items'])) {
            foreach ($data['items'] as $key => $value) {
                $cachekey = $value;
                $cachekeys[$key] = $cachekey;

                if(Cache::has($cachekey)) {
                    $res[$key] = Cache::get($cachekey);
                } else {
                    $nodes[$key] = $this->makeUrl(array('server'=>$data['server'],'itemCode'=>$value));
                }
            }
         }

        $client = new Guzzle(['timeout'=>10,'http_errors'=>false]);

        $requestPromises = [];

        foreach($nodes as $i => $url) {
            $requestPromises[$i] = $client->getAsync($url);
        }

        $results = GuzzlePromise\settle($requestPromises)->wait();

        foreach ($results as $key => $result) {
            if ($result['state'] === 'fulfilled') {
                $response = $result['value'];
                if ($response->getStatusCode() == 200) {

                    $return = json_decode($response->getBody(),true);

                    if(!empty($cachekeys[$key])) {
                        Cache::put($cachekeys[$key],$return, $this->cacheTime);
                    }

                    $res[$key] = $return;
                }
            }
        }

        return $res;
    }



    private function makeUrl($data)
    {

        $url = "https://".$data['server'].".api.battle.net";
        $queryData = array('locale'=>$this->server[$data['server']],'apikey'=>$this->key);
        $queryString = http_build_query($queryData);

        if(!empty($data['battleTag'])) {
            $battleTag = str_replace('#', '-', $data['battleTag']);

            $url .= "/d3/profile/".$battleTag."/";

            if(!empty($data['heroId'])) {
                $url .= "hero/".$data['heroId'];
            }

            if((isset($data['items'])) && $data['items'] == true) {
                $url .= "/items";
            }

            $url .= "?".$queryString;

            return $url;
        } else if(!empty($data['itemCode'])) {
            $url .= "/d3/data/".$data['itemCode'];
            $url .= "?".$queryString;
            return $url;
        } else if(!empty($data['seasonal']) && !empty($data['class'])) {
            $url .= "/data/d3/";
            $url .= $data['type']."/".$data['seasonal']."/leaderboard/rift";

            if($data['gameType'] == 'hardcore') {
                $url .= "-".$data['gameType'];
            }

            $url .= "-".$data['class'];
            $url .= "?access_token=".$this->accessKey;

            return $url;
        } else {
            return false;
        }
    }

    /**
     * Rank조회에 필요한 accessToken값 조회
     *
     * @param
     * @return
     */
    public function getToken()
    {
        $tokenUrl = "https://kr.battle.net/oauth/token?grant_type=client_credentials&client_id=".$this->key."&client_secret=".$this->secret;

        $client = new Guzzle(['timeout'=>30,'http_errors'=>false]);
        $response = $client->request('GET', $tokenUrl);

        if ($response->getStatusCode() == 200) {
            Storage::put('accessToken', $response->getBody());
        } else {
            return false;
        }
    }

    /**
     *
     *
     * @param
     * @return
     */
    public  function setCurrentIndex()
    {

        $nodes = array(
            'https://kr.api.battle.net/data/d3/season/?access_token='.$this->accessKey,
            'https://kr.api.battle.net/data/d3/era/?access_token='.$this->accessKey
        );

        $client = new Guzzle(['timeout'=>10,'http_errors'=>false]);

        $requestPromises = [];
        foreach($nodes as $i => $url) {
            $requestPromises[$i] = $client->getAsync($url);
        }

        $results = GuzzlePromise\settle($requestPromises)->wait();

        foreach ($results as $key => $result) {
            if ($result['state'] === 'fulfilled') {
                $response = $result['value'];
                if ($response->getStatusCode() == 200) {
                    $return = json_decode($response->getBody(),true);
                    $res[$key] = $return;
                }
            }
        }

        $aCurrent = array();
        $aCurrent['current_season'] = $res['0']['current_season'];
        $aCurrent['current_era']    = $res['1']['current_era'];

        Storage::put('currentIndex', json_encode($aCurrent));
    }

}