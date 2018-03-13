@extends('master')
@section('content')
    <section class="index" id="index">
        <div class="container">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="{{ route('weapon') }}">WEAPON</a></li>
                <li role="presentation" class=""><a href="{{ route('cooldown') }}">COOLDOWN</a></li>
            </ul>
            <h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">WEAPON</h3>
            <div class="star-area">
                <hr class="star-dark mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon" aria-hidden="true"></i>
            </div>
            <div class="row">
                <form class="" action="/calc/weapon" name="weaponForm" method="post">
                    {{ csrf_field() }}
                    @php
                        $btnCss = array('btn-primary','btn-default');
                        $weaponType = "normal";

                        if(app('request')->input('weaponType') == "ancient")
                        {
                            $btnCss = array_reverse($btnCss);
                            $weaponType = "ancient";
                        }
                    @endphp
                    <input type="hidden" name="weaponType" value="{{ $weaponType }}" />
                    <!-- nation -->
                    <div class="control-group row">
                        <div class="btn-group pb-2" role="group">
                            <button type="button" class="weaponType btn {{ $btnCss[0] }}" weaponType="normal">일반</button>
                            <button type="button" class="weaponType btn {{ $btnCss[1] }}" weaponType="ancient">고대</button>
                        </div>
                        <div class="form-group controls mb-0" >
                            <select name="weapon" class="form-control">
                                <option value="">무기선택</option>
                                <optgroup label="한손무기">
                                    <option value="1" @if(app('request')->input('weapon') == "1") selected @endif>도끼</option>
                                    <option value="2" @if(app('request')->input('weapon') == "2") selected @endif>단도</option>
                                    <option value="3" @if(app('request')->input('weapon') == "3") selected @endif>철퇴</option>
                                    <option value="4" @if(app('request')->input('weapon') == "4") selected @endif>창</option>
                                    <option value="5" @if(app('request')->input('weapon') == "5") selected @endif>도검</option>
                                    <option value="6" @if(app('request')->input('weapon') == "6") selected @endif>의식용칼</option>
                                    <option value="7" @if(app('request')->input('weapon') == "7") selected @endif>주먹주기</option>
                                    <option value="8" @if(app('request')->input('weapon') == "8") selected @endif>도리깨</option>
                                    <option value="9" @if(app('request')->input('weapon') == "9") selected @endif>거대무기</option>
                                    <option value="10" @if(app('request')->input('weapon') == "10") selected @endif>낫</option>
                                </optgroup>
                                <optgroup label="양손무기">
                                    <option value="11" @if(app('request')->input('weapon') == "11") selected @endif>도끼</option>
                                    <option value="12" @if(app('request')->input('weapon') == "12") selected @endif>철퇴</option>
                                    <option value="13" @if(app('request')->input('weapon') == "13") selected @endif>미늘창</option>
                                    <option value="14" @if(app('request')->input('weapon') == "14") selected @endif>지팡이</option>
                                    <option value="15" @if(app('request')->input('weapon') == "15") selected @endif>도검</option>
                                    <option value="16" @if(app('request')->input('weapon') == "16") selected @endif>대봉</option>
                                    <option value="17" @if(app('request')->input('weapon') == "17") selected @endif>도리깨</option>
                                    <option value="18" @if(app('request')->input('weapon') == "18") selected @endif>거대무기</option>
                                    <option value="19" @if(app('request')->input('weapon') == "19") selected @endif>낫</option>
                                </optgroup>
                                <optgroup label="원거리">
                                    <option value="20" @if(app('request')->input('weapon') == "20") selected @endif>활</option>
                                    <option value="21" @if(app('request')->input('weapon') == "21") selected @endif>쇠뇌</option>
                                    <option value="22" @if(app('request')->input('weapon') == "22") selected @endif>손쇠뇌</option>
                                    <option value="23" @if(app('request')->input('weapon') == "23") selected @endif>마법봉</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group floating-label-form-group controls mb-0">
                            <label>추가 공격력(최소)</label>
                            <input class="form-control damageMin onlyNum" name="damageMin" value="{{ app('request')->input('damageMin') }}" type="text" placeholder="무기 공격력(최소)" required="required" data-validation-required-message="Please enter Min Bonus Damage.">
                            <p class="text-danger" style="display:none;">Please enter Min Bonus Damage.</p>
                        </div>
                        <div class="form-group floating-label-form-group controls mb-2">
                            <label>추가 공격력(최대)</label>
                            <input class="form-control damageMax onlyNum" name="damageMax" value="{{ app('request')->input('damageMax') }}" type="text" placeholder="무기 공격력(최대)" required="required" data-validation-required-message="Please enter Max Bonus Damage.">
                            <p class="text-danger" style="display:none;">Please enter Max Bonus Damage.</p>
                        </div>
                        <div class="form-group controls mb-2" >
                            <select name="damage" class="form-control">
                                <option value="">피해</option>
                                <option value="6" @if(app('request')->input('damage') == "6") selected @endif>6%</option>
                                <option value="7" @if(app('request')->input('damage') == "7") selected @endif>7%</option>
                                <option value="8" @if(app('request')->input('damage') == "8") selected @endif>8%</option>
                                <option value="9" @if(app('request')->input('damage') == "9") selected @endif>9%</option>
                                <option value="10" @if(app('request')->input('damage') == "10") selected @endif>10%</option>
                            </select>
                        </div>
                        <div class="form-group controls">
                            <select name="speed" class="form-control">
                                <option value="">공격속도</option>
                                <option value="5" @if(app('request')->input('speed') == "5") selected @endif>5</option>
                                <option value="6" @if(app('request')->input('speed') == "6") selected @endif>6</option>
                                <option value="7" @if(app('request')->input('speed') == "7") selected @endif>7</option>
                            </select>
                        </div>
                    <br />
                    <div class="form-group">
                        <button type="button" class="btn btn-default btn-xl" id="resetWeapon">Reset
                        </button>
                        <button type="button" class="btn btn-primary btn-xl" id="calcWeapon">Result
                        </button>
                    </div>
                </form>
            </div>
            @if (!empty($result))
            <div id="result" class="row pl-15 pr-15">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">공격력 변경시</h3>
                        </div>
                        <div class="panel-body">
                            @php echo number_format($result['original'],1); @endphp DPS <span class="glyphicon glyphicon-triangle-right"></span>
                            @php $boldCss = ($result['top'] == 'baseDamage') ? "text-primary bold" : ""; @endphp
                            <span class="{{ $boldCss }}">@php echo number_format($result['baseDamage'],1); @endphp</span> DPS
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">피해 변경시</h3>
                        </div>
                        <div class="panel-body">
                            @php echo number_format($result['original'],1); @endphp DPS <span class="glyphicon glyphicon-triangle-right"></span>
                            @php $boldCss = ($result['top'] == 'damage') ? "text-primary bold" : ""; @endphp
                            <span class="{{ $boldCss }}">@php echo number_format($result['damage'],1); @endphp</span> DPS
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">공격속도 변경시</h3>
                        </div>
                        <div class="panel-body">
                            @php echo number_format($result['original'],1); @endphp DPS <span class="glyphicon glyphicon-triangle-right"></span>
                            @php $boldCss = ($result['top'] == 'speed') ? "text-primary bold" : ""; @endphp
                            <span class="{{ $boldCss }}">@php echo number_format($result['speed'],1); @endphp</span> DPS
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">될놈블로급</h3>
                        </div>
                        <div class="panel-body">
                            @php echo number_format($result['best'],1); @endphp DPS
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>
@endsection
