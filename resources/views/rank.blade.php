@extends('master')
@section('content')

    @php
        date_default_timezone_set('UTC');
    @endphp

    <section class="index" id="index">
        <div class="container">
            <ul class="nav nav-tabs">
                <li role="presentation" class="{{ ($type == 'season') ? 'active' : '' }}">
                    <a href="/rank/kr/season/{{ $seasonCurrent['current_season'] }}/barbarian/">SEASON</a>
                </li>
                <li role="presentation" class="{{ ($type == 'era') ? 'active' : '' }}">
                    <a href="/rank/kr/era/{{ $seasonCurrent['current_era'] }}/barbarian">STANDARD</a>
                </li>
            </ul>

            <h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">Season Rank</h3>

            <div class="star-area">
                <hr class="star-dark mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon" aria-hidden="true"></i>
            </div>

            <form class="" action="" name="rankForm" method="get">
                @php
                $btnCss = array('btn-primary','btn-default');

                if($gameType == 'hardcore')
                {
                    $btnCss = array_reverse($btnCss);
                }

                $serverCss = array();
                switch ($server) {
                    case 'us':
                            $serverCss['kr'] = 'btn-default';
                            $serverCss['eu'] = 'btn-default';
                            $serverCss['us'] = 'btn-primary';
                        break;
                    case 'eu':
                            $serverCss['kr'] = 'btn-default';
                            $serverCss['eu'] = 'btn-primary';
                            $serverCss['us'] = 'btn-default';
                        break;
                    case 'kr':
                    default:
                            $serverCss['kr'] = 'btn-primary';
                            $serverCss['eu'] = 'btn-default';
                            $serverCss['us'] = 'btn-default';
                        break;
                }
                @endphp

                <input type="hidden" name="gameType" value="{{ $gameType }}" />
                <input type="hidden" name="server" value="{{ $server }}" />
                <input type="hidden" name="type" value="{{ $type }}" />

                <div class="control-group pl-0">
                    <div class="btn-group pb-2" role="group">
                        <button type="button" class="gameType btn {{ $btnCss['0'] }}" gameType="">일반</button>
                        <button type="button" class="gameType btn {{ $btnCss['1'] }}" gameType="hardcore">하드코어</button>
                    </div>

                    <div class="btn-group pb-2" role="group">
                        <button type="button" class="server btn {{ $serverCss['kr'] }}" server="kr">KR</button>
                        <button type="button" class="server btn {{ $serverCss['us'] }}" server="us">US</button>
                        <button type="button" class="server btn {{ $serverCss['eu'] }}" server="eu">EU</button>
                    </div>
                </div>
                <div class="control-group row pl-0 mb-10">
                    <div class="form-group controls mb-0 col-xs-6 col-md-6 pl-0">
                        <select name="classType" class="form-control">
                        @foreach($classRank as $key=>$val)
                            @php $selected = ($class == $key) ? 'selected' : ''; @endphp
                            <option value="{{ $key }}" {{ $selected }} >{{ $val }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group controls mb-0 col-xs-3 col-md-3 pl-0">
                        <select name="seasonal" class="form-control">
                        @if($type == 'era')
                            @for ($i=$seasonCurrent['current_era']; $i>=1; $i--)
                                @php $selected = ($seasonal == $i) ? 'selected' : ''; @endphp
                                <option value="{{ $i }}" {{ $selected }}>{{ $eraIndex[$i] }}</option>
                            @endfor
                        @else
                            @for ($i=$seasonCurrent['current_season']; $i>=1; $i--)
                                @php $selected = ($seasonal == $i) ? 'selected' : ''; @endphp
                                <option value="{{ $i }}" {{ $selected }}>{{ $i }}시즌</option>
                            @endfor
                        @endif
                        </select>
                    </div>
                    <div class="form-group controls mb-0 col-xs-3 col-md-3 pl-0">
                        <button type="button" class="btn btn-primary btn-block" id="seasonButton">Search</button>
                    </div>
                </div>
            </form>

            <div class="control-group row pl-0" id="search-area">
                <div class="mb-0 col-xs-8 col-md-8 ">
                    <div class="floating-label-form-group">
                        <span class="glyphicon glyphicon-search" style=""></span>
                        <input class="input-control pl-5 battleTag" name="battleTag" value="" type="text" placeholder="Battle Tag">
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 pt-15 rank-btn-block">
                    <span class="rank-btn glyphicon glyphicon-chevron-up floating-up"></span>
                    <span class="rank-btn glyphicon glyphicon-chevron-down floating-down"></span>
                    <span class="rank-text"></span>
                </div>
            </div>

            <table class="table mt-10 table-striped table-hover rank_table">
                <colgroup>
                    <col width="10%"></col>
                    <col width="15%"></col>
                    <col width="13%"></col>
                    <col width="*"></col>
                    <col width="*"></col>
                </colgroup>
                <thead>
                    <tr>
                        <th>RANK</th>
                        <th>BATTLETAG</th>
                        <th class="text-center">단계</th>
                        <th class="text-center">소요시간</th>
                        <th class="text-center complete-time">완료</th>
                    </tr>
                </thead>
                <tbody>
                @php
                $aGender = array('m'=>'male','f'=>'female');
                $heroImgName = array(
                    'barbarian'     =>'barbarian',
                    'crusader'      =>'x1_crusader',
                    'demon hunter'  =>'demonhunter',
                    'monk'          =>'monk',
                    'necromancer'   =>'p6_necro',
                    'witch doctor'  =>'witchdoctor',
                    'wizard'        =>'wizard'
                );

                $aBattleKey = array();
                @endphp

                @foreach ($userList as $userData)

                    @php
                    $playerData = $userData['player'];
                    $rankData   = $userData['data'];
                    @endphp

                    {{-- 같은 사람들이 여러 순위의 기록을 남겼을경우 높은 순위만 출력하기 위한 continue --}}
                    @if($rankData['0']['id'] != "Rank")
                        @continue
                    @endif

                    @foreach($playerData as $key=>$player)

                        @if($player['data']['0']['id'] == "HeroBattleTag")

                        {{-- 같은 사용자가 여러번 다른사람과 트라이했을경우, 높은 순위만 출력한다. --}}
                            @if(in_array($player['data']['0']['string'], $aBattleKey))
                                @continue
                            @endif

                            @php
                            array_push($aBattleKey, $player['data']['0']['string']);

                            $nickname = explode("#", $player['data']['0']['string']);

                            $heroImg    = $heroImgName[$player['data']['2']['string']];
                            $herogender = $aGender[$player['data']['3']['string']];
                            //$heroId = $player['data']['8']['number'] ?? $player['data']['6']['number'];
                            @endphp

                        <tr class="heroesInfo">
                            <td style="position:relative;">
                                @if($key == 0)
                                    <span class="badge rank-number">{{ $rankData['0']['number'] }}</span>
                                @endif
                                <span class="icon-frame" style="background-image:url('http://media.blizzard.com/d3/icons/portraits/42/{{ $heroImg }}_{{ $herogender }}.png'); width:42px; height:42px;">
                                </span>
                            </td>
                            <td class="bold rankTd"><a href="/profile/{{ $server }}/{{ $player['data']['0']['string']}}">{{ $nickname['0'] }}</a></td>
                            <td class="text-center">{{ $rankData['1']['number'] }}<span class="rank-title">단계</span></td>
                            <td class="text-center">{{ Util::riftTime($rankData['2']['timestamp']) }}</td>
                            <td class="complete-time text-center">{{ Util::completeTime($rankData['3']['timestamp']) }}</td>
                        </tr>

                        @else

                        <tr>
                            <td style="position:relative;">
                                @if($key == 0)
                                    <span class="badge rank-number">{{ $rankData['0']['number'] }}</span>
                                @endif
                            </td>
                            <td class="bold"></td>
                            <td class="text-center">{{ $rankData['1']['number'] }}<span class="rank-title">단계</span></td>
                            <td class="text-center">{{ Util::riftTime($rankData['2']['timestamp']) }}</td>
                            <td class="complete-time text-center">{{ Util::completeTime($rankData['3']['timestamp']) }}</td>
                        </tr>

                        @endif
                    @endforeach
                @endforeach

                </tbody>
            </table>

        </div>

    </section>

    <script type="text/javascript">
    $(function() {

        //랭크페이지 상단영역 제어
        $(window).scroll(function() {

            var scTop = $(this).scrollTop();

            if(scTop > 200) {
                $('#search-area').addClass('rank-fixed-on');
                $('.floating').show();
            } else {
                $('#search-area').removeClass('rank-fixed-on');
                $('.floating').hide();
            }
        });

        $('#seasonButton').on("click", function() {

            var server      = $('input[name=server]').val();
            var type        = $('input[name=type]').val();
            var seasonal    = $('select[name=seasonal]').val();
            var classType   = $('select[name=classType]').val();
            var gameType    = $('input[name=gameType]').val();
            var url = "/rank/"+server+"/"+type+"/"+seasonal+"/"+classType;
            if(gameType != "")
            {
                url+= "/"+gameType;
            }
            loading(url);
        });
    });
</script>

@endsection
