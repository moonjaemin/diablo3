@extends('master')
@section('content')
    <section class="index" id="index">
        <div class="container">
            <ul class="nav nav-tabs">
                <li role="presentation" class=""><a href="{{ route('weapon') }}">WEAPON</a></li>
                <li role="presentation" class="active"><a href="{{ route('cooldown') }}">COOLDOWN</a></li>
            </ul>
            <h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">COOLDOWN</h3>
            <!-- <hr class="star-dark mb-5 mt-5"></hr> -->
            <div class="star-area">
                <hr class="star-dark mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon" aria-hidden="true"></i>
            </div>
            <div class="row">
                <form class="" action="" name="coolDownForm" method="post">
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">투구</h3>
                            </div>
                            <div class="panel-body">
                                <select name="head" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="3.5">3.5%</option>
                                    <option value="5">5%</option>
                                    <option value="6.5">6.5%</option>
                                    <option value="8">8%</option>
                                    <option value="10">10%</option>
                                    <option value="10.5">10.5%</option>
                                    <option value="11">11%</option>
                                    <option value="11.5">11.5%</option>
                                    <option value="12">12%</option>
                                    <option value="12.5">12.5%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">어깨</h3>
                            </div>
                            <div class="panel-body">
                                <select name="shoulders" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">장갑</h3>
                            </div>
                            <div class="panel-body">
                                <select name="hands" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">허리띠</h3>
                            </div>
                            <div class="panel-body">
                                <select name="waist" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">반지1</h3>
                            </div>
                            <div class="panel-body">
                                <select name="rightFinger" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">반지2</h3>
                            </div>
                            <div class="panel-body">
                                <select name="leftFinger" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">목걸이</h3>
                            </div>
                            <div class="panel-body">
                                <select name="neck" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">주무기</h3>
                            </div>
                            <div class="panel-body">
                                <select name="mainHand" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                    <option value="9">9%</option>
                                    <option value="10">10%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">보조무기</h3>
                            </div>
                            <div class="panel-body">
                                <select name="offHand" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="5">5%</option>
                                    <option value="6">6%</option>
                                    <option value="7">7%</option>
                                    <option value="8">8%</option>
                                    <option value="9">9%</option>
                                    <option value="10">10%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">레오릭</h3>
                            </div>
                            <div class="panel-body">
                                <select name="leoric" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <?
                                    for ($i=75; $i <= 100; $i++) {
                                    ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">정복자</h3>
                            </div>
                            <div class="panel-body">
                                <input class="form-control coolInput" name="paragon" value="" type="text" placeholder="정복자 포인트" required="" data-validation-required-message="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">신속의 곡옥</h3>
                            </div>
                            <div class="panel-body">
                                <select name="gogok" class="form-control coolSelect">
                                    <option value="">사용안함</option>
                                    <option value="15">사용함(15%)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">보른의 명령</h3>
                            </div>
                            <div class="panel-body">
                                <select name="born" class="form-control coolSelect">
                                    <option value="">사용안함</option>
                                    <option value="10">사용함(10%)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">크림슨 선장</h3>
                            </div>
                            <div class="panel-body">
                                <select name="crimson" class="form-control coolSelect">
                                    <option value="">사용안함</option>
                                    <option value="10">사용함(10%)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">스킬</h3>
                            </div>
                            <div class="panel-body">
                                <select name="skill" class="form-control coolSelect">
                                    <option value="">선택</option>
                                    <option value="15">15%</option>
                                    <option value="20">20%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">재사용 대기 감소</h3>
                            </div>
                            <div class="panel-body">
                                <input class="form-control" name="coolDown" value="" type="text" placeholder="0%" required="" data-validation-required-message="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pl-15">
                        <button type="button" class="btn btn-default btn-xl" id="resetCoolDown">Reset
                        </button>
                        <button type="button" class="btn btn-primary btn-xl" id="coolDownMax">Max
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
