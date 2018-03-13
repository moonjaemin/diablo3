@extends('master')
@section('content')

    <section class="heroes" id="heroes">
        {{ csrf_field() }}
        <div class="container mt-0 pt-20" style="background-color:rgba(0, 0, 0, 0.15);">
            @if (!empty($referer))
            <ul class="pager">
              <li class="previous"><a href="{{ $referer }}"><span aria-hidden="true">&larr;</span> Prev</a></li>
            </ul>
            @endif

            <h3 class="text-center">
                <a href="/profile/{{ $server }}/{{ $battleTag }}" class="battleTag">
                    &lt;@php echo str_replace("-","#",$battleTag); @endphp &gt;
                </a>
            </h3>
            <div class="color-f3e text-center" style="height:50px;font-size:20px;margin-top:10px;">
                {{ $name }} <span class="class-name">{{ $className }}({{ $level }})</span>
                @php
                $css_leaf = ($seasonal == 1) ? 'large-seasonal-leaf' : '';
                @endphp
                <span class="{{ $css_leaf }}"></span>
            </div>

            <h3 class="text-center text-uppercase text-secondary color-f3e mb-0 bold">
                장비
            </h3>
            <div class="star-area">
                <hr class="star-white mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon-white" aria-hidden="true"></i>
            </div>

            <div class="div-gear-slots" style="background: url('/img/{{ $class }}-{{ $gender }}.jpg') -475px -125px no-repeat; ">
                <ul class="gear-slots" >
                    <!-- 머리 -->
                    @foreach($gearList as $gear)
                    <li class="{{ $gear }}">

                        @if(!empty($items[$gear]))
                        <a href="#itemsArea" code="{{ $data }}|{{ $gear }}" class="heroes-gear">
                            <span class="d3-icon d3-icon-item d3-icon-item-{{ $items[$gear]['displayColor'] }}">
                                <span>
                                    <span class="icon-item-inner"></span>
                                </span>
                            </span>
                            <span class="image">
                                <img src="http://media.blizzard.com/d3/icons/items/large/{{ $items[$gear]['icon'] }}.png" alt="" />
                            </span>
                            <span class="sockets-wrapper">
                                <span class="sockets-align">
                                @if(!empty($items[$gear]['attributesRaw']['Sockets']))

                                    @for($i=0; $i < $items[$gear]['attributesRaw']['Sockets']['max']; $i++)
                                    <span class="socket">

                                        @if(!empty($items[$gear]['gems'][$i]))
                                        <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $items[$gear]['gems'][$i]['item']['icon'] }}.png" />
                                        @endif
                                    </span><br />
                                    @endfor

                                @elseif(!empty($items[$gear]['attributesRaw']['ConsumableAddSockets']))

                                    @for($i=0; $i < $items[$gear]['attributesRaw']['ConsumableAddSockets']['max']; $i++)
                                    <span class="socket">

                                        @if(!empty($items[$gear]['gems'][$i]))
                                        <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $items[$gear]['gems'][$i]['item']['icon'] }}.png" />
                                        @endif
                                    </span><br />
                                    @endfor

                                {{-- socket, ConsumableAddSockets이 없을경우에 .. (예:파랑무 원시인검) --}}
                                @elseif(!empty($items[$gear]['gems']))

                                    @foreach($items[$gear]['gems'] as $gemData)
                                    <span class="socket">
                                        <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $gemData['item']['icon'] }}.png" />
                                    </span><br/>
                                    @endforeach
                                @endif
                                </span>
                            </span>
                        </a>
                    @endif
                    </li>
                    @endforeach <!-- //endforeach -->
                </ul>
            </div>
        </div>
    </section>

    <section class="skill-bg">
        <div class="container mt-0 pt-20" style="background-color:rgba(0, 0, 0, 0.15);">
            <h3 class="text-center text-uppercase text-secondary color-f3e mb-0 bold mt-30">
                기술
            </h3>
            <div class="star-area">
                <hr class="star-white mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon-white" aria-hidden="true"></i>
            </div>
            <div class="skill-div">
                <ul class="skills">

                @php $i=0; @endphp

                @foreach($skills['active'] as $skill)
                    @php
                    $frCss = ($i % 2 == 1) ? 'fr' : '';
                    $skillName = "";
                    $runeName = "";
                    @endphp

                    @if(!empty($skill['skill']))
                        @php
                        $skillName = str_limit($skill['skill']['name'],15,'..');
                        if(!empty($skill['rune']['name']))
                        {
                            $runeName = str_limit($skill['skill']['name'],16,'..');
                        }
                        @endphp

                    <li class="{{ $frCss }}">
                        <a href="#skillArea" class="skill-data" slug="{{ $skill['skill']['slug'] }}">
                            <div class="skill-info">
                                <span style="background:url('http://media.blizzard.com/d3/icons/skills/42/{{ $skill['skill']['icon'] }}.png') no-repeat;" class="skill-icon skill-icon-empty"></span>
                                <span class="skill-name" style="">{{ $skillName }}</span><br/>
                                <span class="skill-passive" style="">{{ $runeName }}</span>
                                <span class="skill-position-{{ $i }}"></span>
                            </div>
                        </a>
                    </li>
                    @else
                    <li class="{{ $frCss }}">
                        <div class="skill-info">
                            <span style="background: url('/img/skill-overlays.png')0 0; background-position: -132px -41px;" class="skill-icon skill-icon-empty"></span>
                            <span class="skill-name" style=""></span><br/>
                            <span class="skill-passive" style=""></span>
                            <span class="skill-position-{{ $i }}"></span>
                        </div>
                    </li>
                    @endif
                    @php $i++; @endphp
                @endforeach
                </ul>
            </div>

            <div class="passive-div">
                <ul class="passive">
                @php $i=0; @endphp

                @foreach($skills['passive'] as $passive)

                    @php
                        $frCss = ($i % 2 == 1) ? 'fr' : '';
                        $passiveName = str_limit($passive['skill']['name'],14,'..');
                    @endphp

                    @if(!empty($passive['skill']))
                    <li class="{{ $frCss }}">
                        <a href="#skillArea" class="skill-data" slug="{{ $passive['skill']['slug'] }}">
                            <div class="passive-info">
                                <span class="passive-icon" style="background-position: -0px -41px;">
                                    <img src="http://media.blizzard.com/d3/icons/skills/42/{{ $passive['skill']['icon'] }}.png" />
                                </span>
                                <span class="passive-name">{{ $passiveName }}</span>
                            </div>
                        </a>
                    </li>
                    @else
                    <li class="{{ $frCss }}">
                        <div class="passive-info">
                            <span class="passive-icon" style="background-position: -82px -41px;"></span>
                            <span class="passive-name"></span>
                        </div>
                    </li>
                    @endif
                    @php $i++; @endphp
                @endforeach
                </ul>
            </div>

            <h3 class="text-center text-uppercase text-secondary color-f3e mb-0 bold mt-50">
                카나이함
            </h3>
            <div class="star-area">
                <hr class="star-white mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon-white" aria-hidden="true"></i>
            </div>
            <div class="legendary-powers-wrapper">
            @php
            $aKanai = array('weapon','armor','jewelry');
            $i = 0;
            @endphp

            @foreach($aKanai as $kanai)

                @php $isActive = (!empty($legendaryPowers[$i])) ? "is-active" : "legendary-power-".$kanai.""; @endphp
				<div class="legendary-power-wrapper">
                    <div class="legendary-power-container {{ $isActive }}">
                        @if(!empty($legendaryPowers[$i]))
                        <a href="#kanaiArea" class="legendary-power-item" key="{{ $legendaryPowers[$i]['type']['id'] }}" style="background-image: url(http://media.blizzard.com/d3/icons/items/large/{{ $legendaryPowers[$i]['icon'] }}.png);"></a>
                    @endif
                    </div>
				</div>
                @php $i++; @endphp
            @endforeach
            </div>
            <h3 class="text-center text-uppercase text-secondary color-f3e mb-0 bold" style="margin-top:-50px">
                능력치
            </h3>
            <div class="star-area">
                <hr class="star-white mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon-white" aria-hidden="true"></i>
            </div>
            <div class="hero-stats-wrapper">
                <dl class="hero-stats-list">
                    <dt>힘</dt>
                    <dd>@php echo number_format($stats['strength']); @endphp</dd>
                    <dt>민첩</dt>
                    <dd>@php echo number_format($stats['dexterity']); @endphp</dd>
                    <dt>지능</dt>
                    <dd>@php echo number_format($stats['intelligence']); @endphp</dd>
                    <dt>활력</dt>
                    <dd>@php echo number_format($stats['vitality']); @endphp</dd>
                </dl>
                <dl class="hero-stats-list">
                    <dt>공격력</dt>
                    <dd>@php echo number_format($stats['damage']); @endphp</dd>
                    <dt>강인함</dt>
                    <dd>@php echo number_format($stats['toughness']); @endphp</dd>
                    <dt>회복력</dt>
                    <dd>@php echo number_format($stats['healing']); @endphp</dd>
                    <dt>생명력</dt>
                    <dd>@php echo number_format($stats['life']); @endphp</dd>
                    <dt>방어도</dt>
                    <dd>@php echo number_format($stats['armor']); @endphp</dd>
                </dl>
                <dl class="hero-stats-list">
                    <dt>물리저항</dt>
                    <dd>@php echo number_format($stats['physicalResist']); @endphp</dd>
                    <dt>냉기저항</dt>
                    <dd>@php echo number_format($stats['coldResist']); @endphp</dd>
                    <dt>화염저항</dt>
                    <dd>@php echo number_format($stats['fireResist']); @endphp</dd>
                    <dt>번개저항</dt>
                    <dd>@php echo number_format($stats['lightningResist']); @endphp</dd>
                    <dt>독저항</dt>
                    <dd>@php echo number_format($stats['poisonResist']); @endphp</dd>
                    <dt>비전/신성저항</dt>
                    <dd>@php echo number_format($stats['arcaneResist']); @endphp</dd>
                <dl>
            </div>
        </div>
    </section>
    <div class="modal fade" id="itemsArea">
        <div class="modal-dialog">
            <div id="itemInfo"></div>
        </div>
    </div>
    <!-- skill area -->

    <div class="modal fade" id="skillArea">
        <div class="modal-dialog">
            @include('include.skill')
        </div>
    </div>

    <div class="modal fade" id="kanaiArea">
        <div class="modal-dialog">
            @include('include.kanai')
        </div>
    </div>


@endsection
