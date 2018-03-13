<a href="javascript:;" data-dismiss="modal" aria-label="close" class="btn-close-a">
    <span class="btn-close"></span>
</a>
<div class="ui-tooltip topLeft ui-tooltip-d3" style="">
    <div class="tooltip-content">
        <div class="d3-tooltip d3-tooltip-item">
            @php $legendaryCss = "legendary"; @endphp
            @if(!empty($attributesRaw['Ancient_Rank']['max']) && $attributesRaw['Ancient_Rank']['max'] == '1')
                @php $legendaryCss = "AncientLegendary"; @endphp
            @elseif(!empty($attributesRaw['Ancient_Rank']['max']) && $attributesRaw['Ancient_Rank']['max'] == '2')
                @php $legendaryCss = "PrimalAncientLegendary"; @endphp
            @endif

            @php $iconCss = 'icon-item-default'; @endphp
            @if(in_array(strtolower($type['id']), array('genericbelt','amulet','ring')))
                @php $iconCss = 'icon-item-square'; @endphp
            @endif
            <div class="d3-tooltip-item-wrapper d3-tooltip-item-wrapper-{{ $legendaryCss }}">
                <div class="d3-tooltip-item-border d3-tooltip-item-border-left"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-right"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-top"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-bottom"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-top-left"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-top-right"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-bottom-left"></div>
                <div class="d3-tooltip-item-border d3-tooltip-item-border-bottom-right"></div>

                <div class="tooltip-head tooltip-head-{{ $displayColor }}">
                    <h3 class="d3-color-{{ $displayColor }}">{{ $name }}</h3>
                </div>
                <div class="tooltip-body effect-bg effect-bg-armor effect-bg-armor-default">
                    <span class="d3-icon d3-icon-item d3-icon-item-large  d3-icon-item-{{ $displayColor }}">
                        <span class="icon-item-gradient">
                            <span class="icon-item-inner {{ $iconCss }}" style="background-image: url(http://media.blizzard.com/d3/icons/items/large/{{ $icon }}.png); ">
                            </span>
                        </span>
                    </span>
                    <div class="d3-item-properties">
                        <ul class="item-type-right">
                            {{-- <li class="item-slot">{{ $typeName }}</li>
                            <li class="item-class-specific d3-color-white">마법사</li> --}}
                        </ul>
                        <ul class="item-type">
                            <li>
                                <span class="d3-color-{{ $displayColor }}">{{ $typeName }}</span>
                            </li>
                        </ul>

                        @if(!empty($armor))
                        <ul class="item-armor-weapon item-armor-armor">
                            <li class="big"><span class="value">@php echo number_format($armor); @endphp</span></li>
                            <li>방어구</li>
                        </ul>
                        @endif

                        @if(!empty($blockChance))
                        <ul class="item-armor-weapon item-armor-shield">
                            <li>
                                <span class="value">
                                    <p><span class="d3-color-FF888888">@php echo str_replace("\n","<p>",$blockChance); @endphp</span></p>
                                </span>
                            </li>
                        </ul>
                        @endif

                        @if(!empty($dps))
                        {{-- 무기일때 --}}
                        <ul xmlns="http://www.w3.org/1999/xhtml" class="item-armor-weapon item-weapon-dps">
                            <li class="big"><span class="value">{{ $dps }}</span></li>
                            <li>초당 공격력</li>
                        </ul>
                        <ul xmlns="http://www.w3.org/1999/xhtml" class="item-armor-weapon item-weapon-damage">
                			<li>
                                <span class="value"><p><span class="color-909091">무기 공격력 </span>
                                <span class="d3-color-FF888888">
                                    @php echo number_format($minDamage); @endphp ~
                                    @php echo number_format($maxDamage); @endphp
                                </span></p>
                            </li>
                            <li>
                                <span class="value"><p><span class="color-909091">초당 공격 횟수</span>
                                <span class="d3-color-FF888888">{{ $attacksPerSecond }}</span></p>
                            </li>
                		</ul>
                        @else
                            {{-- 악세사리 --}}
                        @endif

                        <div class="item-before-effects"></div>
                        <ul class="item-effects">
                        @foreach($attributesHtml as $key=>$value)
                            @if(!empty($value))
                                @php echo ($key == "secondary") ? '<p class="item-property-category">보조 속성</p>' : ''; @endphp
                                @foreach($value as $attrData)
                                    @php echo $attrData."<br />"; @endphp
                                @endforeach
                            @endif
                        @endforeach

                        @if(!empty($gems))
                            @foreach($gems as $gem)
                                @if($gem['isJewel'] == 1)
                                {{-- 전설보석 --}}
                                <li class="d3-color-orange full-socket">
                                    <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $gem['item']['icon'] }}.png" />
                                    <div class="mt-0 ml-10 jewel-effect">
                                    @php echo str_replace("\n","<p>",$gem['attributes']['0']); @endphp
                                    </div>
                                </li>
                                @else
                                {{-- 기본보석 --}}
                                <li class="d3-color-white full-socket">
                                    <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $gem['item']['icon'] }}.png" />
                                    <span>
                                        <span>
                                            <p><span class="tooltip-icon-bullet"></span> {{ $gem['attributes']['0'] }}</p><p></p>
                                        </span>
                                    </span>
                                </li>

                                @endif
                            @endforeach
                        @endif
                        @if(!empty($dye))
                            <p class="item-property-category d3-color-blue">Dye:</p>
                            <li class="value">{{ $dye['name'] }}</li>
                        @endif

                        @if(!empty($transmog))
                            <p class="item-property-category d3-color-blue">Transmogrification:</p>
                            <li class="value">{{ $transmog['name'] }}</li>
                        @endif
                        </ul>
                        {{-- 세트아이템일때 --}}

                        @if(!empty($set))
                        <span class="d3-color-ff00ff00">{{ $set['name'] }}</span><br />
                        {!! $set['descriptionHtml'] !!}
                        @endif
                        <ul class="item-extras">
                            <li class="item-reqlevel">최소 요구 레벨: {{ $requiredLevel }}</li>
                        </ul>
                        <span class="clear"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
