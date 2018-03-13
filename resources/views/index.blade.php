@extends('master')
@section('content')
    <section class="index" id="index">
        <div class="container" id="my-element">
            <h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">Profile</h3>
            <!-- <hr class="star-dark mb-5 mt-5"></hr> -->
            <div class="star-area">
                <hr class="star-dark mb-5 mt-5"></hr>
                <i class="fa fa-star star-icon" aria-hidden="true"></i>
            </div>
            <!-- <span class="glyphicon glyphicon-asterisk star-light"></span> -->
            <div class="row">
                <div class="">
                    <form class="" action="/d3/profile/" name="battleTagForm" onsubmit="return false">
                        <!-- nation -->
                        <div class="control-group">
                          <div class="form-group controls mb-0 pb-2">
                            <select name="server" class="form-control">
                              <option value="kr">한국</option>
                              <option value="us">미국</option>
                              <option value="eu">유럽</option>
                            </select>
                          </div>
                          <div class="form-group floating-label-form-group controls mb-0 pb-0">
                            <label>BattleTag</label>
                            <input class="form-control battleTag" name="battleTag" value="" type="text" placeholder="Battle Tag (ex. 무말랭#31679)" required="required" data-validation-required-message="Please enter your battle tag.">
                            <p class="text-danger" style="display:none;">Please enter your battle tag.</p>
                          </div>
                        </div>

                        <br />
                        <div class="form-group pl-15">
                          <button type="button" class="btn btn-primary btn-xl searchBattleTag" id="sendMessageButton" >Search</button>
                        </div>
                    </form>
                </div>
            </div> <!-- //row -->
            @if (count($lastBattleTags) > 1)
            <div class="list-group">
                @foreach ($lastBattleTags as $val)
                    @php list($battleTag,$server) = explode("|", $val); @endphp
                    <a href="profile/{{ $server }}/{{ $battleTag }}" class="list-group-item lastBattleTags" >
                    @php echo str_replace("-","#",$battleTag)@endphp
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </section>
@endsection