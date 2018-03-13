
{{-- 스킬영역 --}}
@foreach ($legendaryPowers as $kanaiData)
	<div id="{{ $kanaiData['type']['id'] }}" class="kanai-data-div" style="display:none;">
		<a href="javascript:;" data-dismiss="modal" aria-label="close" class="btn-close-a">
			<span class="btn-close"></span>
		</a>
		<div class="ui-tooltip" style="">
			<div class="tooltip-content">
				<div class="d3-tooltip d3-tooltip-trait">
					<div class="tooltip-head">
						<h3 class="">{{ $kanaiData['name'] }}</h3>
					</div>
					<div class="tooltip-body ">
						<div class="description">
						@if(!empty($kanaiData['attributes']))

							@foreach($kanaiData['attributes'] as $key=>$value)

								@if(!empty($value))
									@foreach($value as $attrData)
                                        @php echo "<p>".$attrData['textHtml']."</p>"; @endphp
                                    @endforeach
								@endif

                            @endforeach
						@endif
						</div>
					</div>
					<div class="tooltip-extension ">
						<div class="flavor">@php echo nl2br($kanaiData['flavorText']); @endphp</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
