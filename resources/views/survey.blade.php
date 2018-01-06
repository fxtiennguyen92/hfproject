@extends('template.index')

@push('stylesheets')
	<style>
		input.input-other {
			display: inline !important;
			background: transparent !important;
		}
		input.input-other:focus {
			outline: none;
		}
	</style>

	<!-- Page Scripts -->
	<script>
	$(document).ready(function() {
		$('#surveyList').steps({
			headerTag: 'h3',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			autoFocus: true
		});

		$('a[href=#finish]').on('click', function() {
			$('#frmMain').submit();
		});

		$('#btnLocation').on('click', function() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showLocation);
			} else { 
				$.notify({
					title: '<strong>Thất bại! </strong>',
					message: 'Trình duyệt không hỗ trợ tìm vị trí tự động.'
				},{
					type: 'danger',
				});
				$('#inpLocation').html('Không tìm thấy vị trí của bạn');
			}
		});

		function showLocation(position) {
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;
			$.ajax({
				type: 'GET',
				url: '{{ route("get_location") }}',
				data: 'latitude='+latitude+'&longitude='+longitude,
				success: function(msg) {
					if (msg) {
						$('#inpLocation').val(msg);
					} else {
						$('#inpLocation').val('Không tìm thấy vị trí của bạn');
					}
				}
			});
		}
	});
	</script>
@endpush

@section('title')
	Thông Tin Sự Cố
@endsection

@section('content')
<section class="page-content">
	<form id="frmMain" method="POST" action="{{ route('submit_order_details') }}">
	<div id="surveyList" class="cui-wizard cui-wizard__numbers">
		@foreach ($questions as $q)
			<h3><span class="cui-wizard--steps--title"></span></h3>
			<section>
				<div class="question col-md-12">
					<label>{{ $q->order_dsp.'/'.count($questions) }}</label>
					<label>{{ $q->content }}</label>
				</div>
				<div class="answwer col-md-12 col-sm-12 col-xs-12">
				@if ($q->answer_type == '0')
					<div class="form-group">
						<textarea class="form-control" rows="5"
							name="q[{{ $q->id }}]"></textarea>
					</div>
				@elseif ($q->answer_type == '1')
					<div class="btn-group col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">
					@foreach ($q->answers as $a)
						<label class="btn btn-default-outline col-md-5 col-sm-5 col-xs-12" >
							@if ($a->init_flg == 2)
							<input type="checkbox" name="q[{{ $q->id }}][]" value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>	
							<input class="input-other" type="text" name="{{ $q->id.'_'.$a->order_dsp }}_text" value="" placeholder="{{ $a->content }}">
							@else
							<input type="checkbox" name="q[{{ $q->id }}][]" value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>	
								{{ $a->content }}
							@endif
						</label>
					@endforeach
					</div>
				@elseif ($q->answer_type == '2')
					<div class="btn-group col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">
					@foreach ($q->answers as $a)
						<label class="btn btn-default-outline col-md-5 col-sm-5 col-xs-12 ">
							<input type="radio" name="q[{{ $q->id }}]" value="{{ $a->order_dsp }}">
							<span class="icon icmn-radio-unchecked"></span>	
								{{ $a->content }}
						</label>
					@endforeach
					</div>
				@endif
				</div>
			</section>
		@endforeach
		
		<h3><span class="cui-wizard--steps--title"></span></h3>
		<section>
			<div class="question col-md-12">
				<label>Vị trí</label>
			</div>
			<div class="answwer col-md-12 col-sm-12 col-xs-12">
				<div class="input-group">
					<input type="text" class="form-control"
						id="inpLocation" name="address">
					<a class="input-group-addon"
						id="btnLocation"><i class="icmn-search5"></i></a>
				</div>
			</div>
			<div class="question col-md-12">
				<label>Thời gian</label>
			</div>
			<div class="answwer col-md-12 col-sm-12 col-xs-12">
				<div class="btn-group col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">
					<label class="btn btn-default-outline col-md-5 col-sm-5 col-xs-12 ">
						<input type="checkbox" name="time" value="0">
						<span class="icon icmn-clock3"></span>	
							Càng sớm càng tốt
					</label>
					<label class="btn btn-default-outline col-md-5 col-sm-5 col-xs-12 ">
						<input type="checkbox" name="time" value="1">
						<span class="icon icmn-calendar2"></span>	
							Thỏa thuận thời gian
					</label>
				</div>
			</div>
		</section>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</div>
	</form>
</section>
@endsection