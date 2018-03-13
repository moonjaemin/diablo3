<h3 class="text-center text-uppercase text-secondary color-2c3 mb-0 bold">{{ $guildName }} list</h3>
<div class="star-area">
    <hr class="star-dark mb-5 mt-5"></hr>
    <i class="fa fa-star star-icon" aria-hidden="true"></i>
</div>
<div class="list-group">
    @foreach($guildMembers as $guildMember)
    <a href="/profile/{{ $server }}/{{ $guildMember->battle_tag }}" class="list-group-item lastBattleTags">{{ $guildMember->battle_tag }}</a>
    @endforeach
</div>
<div class="text-center">
{{ $guildMembers->links() }}
</div>