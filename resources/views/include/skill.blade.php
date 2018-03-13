
{{-- 스킬영역 --}}
@foreach($skills['active'] as $skill)
    @empty ($skill)
        @continue
    @endempty
	{{-- @if(empty($skill))
		@continue
    @endif --}}

	@php $skillData = $skill['skill']; @endphp

	<div id="skill-{{ $skillData['slug'] }}" class="skill-data-div" style="display:none;">
		<a href="javascript:;" data-dismiss="modal" aria-label="close" class="btn-close-a">
		    <span class="btn-close"></span>
		</a>
		<div class="ui-tooltip">
			<div class="tooltip-content">
				<div class="d3-tooltip">

					<div class="tooltip-head">
						<h3 class="">{{ $skillData['name'] }}</h3>
					</div>

					<div class="tooltip-body skill-extension">
						<span class="d3-icon d3-icon-rune d3-icon-rune-large">
							<span style="background-image: url('http://media.blizzard.com/d3/icons/skills/64/{{ $skillData['icon'] }}.png'); background-size:44px 44px;"></span>
						</span>
						<p>@php echo nl2br($skillData['description']); @endphp</p>
						<p class="subtle"><em>{{ $skillData['level'] }}</em> 레벨에 사용할 수 있습니다.</p>
					</div>

					@if(!empty($skill['rune']))
						@php $runeData = $skill['rune']; @endphp
					<div class="tooltip-extension rune-extension">
						<span class="d3-icon d3-icon-rune d3-icon-rune-large">
							<span class="rune-{{ $runeData['type'] }}"></span>
						</span>
						<span class="color-f3e fsize-18">{{ $runeData['name'] }}</span>
						<p>@php echo nl2br($runeData['description']); @endphp</p>
						<p class="subtle"><em>{{ $runeData['level'] }}</em> 레벨에 사용할 수 있습니다.</p>
					</div>
                    @endif
				</div>
			</div>
		</div>
	</div>
@endforeach


{{-- 패시브 영역 --}}

@foreach ($skills['passive'] as $passive)
    @empty ($passive)
        @continue
    @endempty

	@php $passiveData = $passive['skill']; @endphp

	<div id="skill-{{ $passiveData['slug'] }}" class="skill-data-div" style="display:none;">
		<a href="javascript:;" data-dismiss="modal" aria-label="close" class="btn-close-a">
		    <span class="btn-close"></span>
		</a>
		<div class="ui-tooltip" style="">
			<div class="tooltip-content">
				<div class="d3-tooltip d3-tooltip-trait">
					<div class="tooltip-head">
						<h3 class="">{{ $passiveData['name'] }}</h3>
					</div>
					<div class="tooltip-body skill-extension">
						<span class="d3-icon d3-icon-rune d3-icon-rune-large">
							<span style="background-image: url('http://media.blizzard.com/d3/icons/skills/64/{{ $passiveData['icon'] }}.png'); background-size:44px 44px;"></span>
						</span>
						<div class="description">
							<p>
								@php echo nl2br($passiveData['description']); @endphp
							</p>
							<p class="subtle"><em>{{ $passiveData['level'] }}</em> 레벨에 사용할 수 있습니다.</p>
						</div>
					</div>
					<div class="tooltip-extension ">
						<div class="flavor">@php echo nl2br($passiveData['flavorText']); @endphp</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
