@extends('master')
@section('content')
    <section class="profile" id="profile">
        <div class="container">
            <ul class="pager">
            @if (!empty($referer))
                <li class="previous"><a href="{{ $referer }}"><span aria-hidden="true">&larr;</span> Prev</a></li>
            @else
                <li class="previous"><a href="{{ route('home') }}"><span aria-hidden="true">&larr;</span> Prev</a></li>
            @endif
            </ul>
            <h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">{{ $guildName }} {{ $battleTag }}</h3>
            <div class="star-area">
                <hr class="star-dark mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon" aria-hidden="true"></i>
            </div>

            <table class="table table-striped text-center">
                <thead>
                    <tr class="bold">
                        <td>스텐</td>
                        <td>시즌</td>
                        <td>하드코어</td>
                        <td>하드코어시즌</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $paragonLevel }}</td>
                        <td>{{ $paragonLevelSeason }}</td>
                        <td>{{ $paragonLevelHardcore }}</td>
                        <td>{{ $paragonLevelSeasonHardcore }}</td>
                    </tr>
                </tbody>
            </table>

            <p class="text-right"><span class="glyphicon glyphicon-time"></span> {{ $lastUpdated }}</p>
            <!-- //시즌영웅 -->
            <table class="table table-striped table-hover">

                <thead>
                    <colgroup>
                        <col width="120px"></col>
                        <col></col>
                    </colgroup>
                </thead>
                <tbody>
                    @forelse($seasonHeroes as $hero)
                    <tr class="heroesInfo">
                        <td class="text-center" style="width:120px !important;">
                            <a href="/profile/{{ $server }}/{{ $battleTag }}/hero/{{ $hero['id'] }}" class="{{ $hero['classSlug'] }}{{ $hero['gender'] }}">
                                <span class="hero-portrait">
                                    <span class="small-seasonal-leaf"></span>
                                </span>
                            </a>
                        </td>
                        @if(!empty($items[$hero['id']]))
                        <td>
                            <span>{{ $hero['name'] }}</span>
                            <span class="fsize-11">{{ $hero['class'] }} ({{ $hero['level'] }})</span>
                            <div>
                            @foreach($items[$hero['id']] as $value)
                                @if(!empty($value['gems']))
                                    @foreach($value['gems'] as $gem)
                                        @if($gem['isJewel'] == 1)
                                        <div class="jewel-info">
                                            <span>
                                                <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $gem['item']['icon'] }}.png" />
                                            </span>
                                            <span class="jewel-level fsize-11">({{ $gem['jewelRank'] }})</span>
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            </div>
                        </td>
                        @else
                        <td>
                            <span>{{ $hero['name'] }}</span>
                            <span class="fsize-11">{{ $hero['class'] }} ({{ $hero['level'] }})</span>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2"><p class="text-center"></p></td>
                    </tr>
                    @endforelse
                    @forelse($heroes as $hero)
                    <tr class="heroesInfo">
                        <td class="text-center" style="width:120px !important;">
                            <a href="/profile/{{ $server }}/{{ $battleTag }}/hero/{{ $hero['id'] }}" class="{{ $hero['classSlug'] }}{{ $hero['gender'] }}">
                                <span class="hero-portrait">
                                </span>
                            </a>
                        </td>
                        @if(!empty($items[$hero['id']]))
                        <td>
                            <span>{{ $hero['name'] }}</span>
                            <span class="fsize-11">{{ $hero['class'] }} ({{ $hero['level'] }})</span>
                            <div>
                            @foreach($items[$hero['id']] as $value)
                                @if(!empty($value['gems']))
                                    @foreach($value['gems'] as $gem)
                                        @if($gem['isJewel'] == 1)
                                        <div class="jewel-info">
                                            <span>
                                                <img class="gem" src="http://media.blizzard.com/d3/icons/items/small/{{ $gem['item']['icon'] }}.png" />
                                            </span>
                                            <span class="jewel-level fsize-11">({{ $gem['jewelRank'] }})</span>
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            </div>
                        </td>
                        @else
                        <td>
                            <span>{{ $hero['name'] }}</span>
                            <span class="fsize-11">{{ $hero['class'] }} ({{ $hero['level'] }})</span>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2"><p class="text-center"></p></td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
                @if(count($guildMembers) > 0)
                <div id="page_container">
                    @include('include.members')
                </div>
                @endif
        </div>
        <script type="text/javascript">
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                }else{
                    getData(page);
                }
            }
        });

        $(function() {
            $(document).on('click', '.pagination a',function(event) {
                event.preventDefault();
                $('li').removeClass('active');
                $(this).parent('li').addClass('active');
                var myurl = $(this).attr('href');
                var page=$(this).attr('href').split('page=')[1];
                getData(page);
            });
        });

        function getData(page) {
            $.ajax({
                url: '?page=' + page,
                type: "get",
                datatype: "html"
            }).done(function(data) {
                $("#page_container").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                  alert('No response from server');
            });
        }
        </script>
    </section>
@endsection
