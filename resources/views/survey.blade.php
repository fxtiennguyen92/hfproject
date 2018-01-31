@extends('template.index')

@push('stylesheets')
	<link rel="stylesheet" type="text/css" href="css/question.css">
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
		autosize($('.autosize'));
		$('#surveyList').steps({
			headerTag: 'h3',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			autoFocus: true,
			enableAllSteps: true,
			labels: {
				finish: "Bước cuối cùng",
				next: "Tiếp theo",
				previous: "Quay lại",
			},
			onStepChanging: function(e, currentIndex, newIndex) {
				if (currentIndex < newIndex) {
					var name = $('section[id=surveyList-p-' + currentIndex +']')
								.find('input:not([type=text],[type=button],[type=submit])')
								.first()
								.attr('name');
					if ($('input[name="' + name + '"]:checked').length == 0) {
						$.notify({
							message: 'Hãy trả lời câu hỏi bên dưới.'
						},{
							type: 'danger',
							delay: 1500,
						});
						return false;
					};

					$('.input-other').on('blur', function() {
						if ($(this).parent().hasClass('active') && $.trim($(this).val()) == '') {
							$(this).focus();
						}
					});
				}
				return true;
			},
			onStepChanged: function() {
				fixScreen();
			},
		});
		$('a[href=#finish]').on('click', function() {
			$('#positionAndTime').show();
			$('#surveyList').hide();
		});
		$('#btnBack').on('click', function() {
			$('#positionAndTime').hide();
			$('#surveyList').show();
		});
		$('.datetimepicker').datetimepicker({
			minDate: moment(),
			locale: moment.locale('vi'),
			format: 'dddd, DD/MM/YYYY HH:ss',
			widgetPositioning: {
				horizontal: 'auto',
				vertical: 'top'
			},
			icons: {
				time: 'fa fa-clock-o',
				date: 'fa fa-calendar',
				up: 'fa fa-chevron-up',
				down: 'fa fa-chevron-down',
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'fa fa-screenshot',
				clear: 'fa fa-trash',
				close: 'fa fa-remove'
			}
		});
		$('#ddCity').on('change', function() {
			$('#ddDist').children('option').remove();

			var url = '{{ route("get_dist_by_city", ["code" => "cityCode"]) }}';
			url = url.replace('cityCode', $(this).val());
			$.ajax({
				url: url,
				success: function (data) {
					$.each(data, function(key, value) {
						$('#ddDist').append($('<option></option>')
									.attr('value', value.code)
									.text(value.name));
					});
					$('#ddDist').focus();
				}
			});
		});
		$('.label-other').on('click', function() {
			if (!$(this).hasClass('active')) {
				$(this).find('.input-other').focus();
			}
		});
		$('#frmMain').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						$.ajax({
							type: 'POST',
							url: '{{ route("submit_order_details") }}',
							data: $('#frmMain').serialize(),
							success: function(response) {
								location.href='{{ route("complete_order") }}';
							},
							error: function(xhr) {
								if (xhr.status == 400) {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Đã có lỗi xảy ra, mời bạn chọn lại dịch vụ.'
									},{
										type: 'danger',
										z_index: 1051,
									});

									setTimeout(function() {
										location.reload();
									}, 1500);

									location.href('{{ route("home_page") }}');
								} else {
									$.notify({
										title: '<strong>Thất bại! </strong>',
										message: 'Không thể thực hiện đăng tin.'
									},{
										type: 'danger',
										z_index: 1051,
									});

									setTimeout(function() {
										location.reload();
									}, 1500);
								};
							}
						});
					}
				}
			}
		});
	});

	function fixScreen() {
		if ($('.content').outerHeight() > 500) {
			$('.page-content').css('position', 'relative');
			$('.actions').css('position', 'fixed');
			$('.actions').css('bottom', '0px');
			$('.page-content').css('height', '100vh');
		}
		else {	
			$('.page-content').css('position', 'relative');
			$('.page-content').css('height', '86vh');
			$('.page-content').css('bottom', '0px');
			$('.actions').css('position', 'fixed');
		}
	};
	</script>
@endpush

@section('title')
	Thông Tin Sự Cố
@endsection

@section('content')
<section class="page-content" style="bottom: 0px; position: relative; height: 86vh;">
	<form id="frmMain" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('submit_order_details') }}">
	<div id="surveyList" class="cui-wizard cui-wizard__numbers">
		@foreach ($questions as $q)
			<h3><span class="cui-wizard--steps--title"></span></h3>
			<section>
				<div class="question col-md-12">
					<label>{{ $q->order_dsp.'/'.count($questions) }} {{ $q->content }}</label>
				</div>
				<div class="answer col-md-12 col-sm-12 col-xs-12">
				@if ($q->answer_type == '0')
					<div class="form-group">
						<textarea class="form-control autosize"
							name="q[{{ $q->id }}]"></textarea>
					</div>
				@elseif ($q->answer_type == '1')
					<div class="btn-group col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">
					@foreach ($q->answers as $a)
						@if ($a->init_flg == 2)
						<label class="label-other btn btn-default-outline col-md-qw col-sm-5 col-xs-12" >
							<input type="checkbox"
									name="q[{{ $q->id }}][]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>
							<input class="input-other" type="text"
									placeholder="{{ $a->content }}"
									name="{{ $q->id.'_'.$a->order_dsp }}_text"
									value="">
						</label>
						@else
						<label class="btn btn-default-outline col-md-qw col-sm-5 col-xs-12" >
							<input type="checkbox"
									name="q[{{ $q->id }}][]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-checkbox-unchecked2"></span>
								{{ $a->content }}
						</label>
						@endif
					@endforeach
					</div>
				@elseif ($q->answer_type == '2')
					<div class="btn-group col-md-12 col-sm-12 col-xs-12" data-toggle="buttons">
					@foreach ($q->answers as $a)
						<label class="btn btn-default-outline col-md-5 col-sm-5 col-xs-12 ">
							<input type="radio"
									name="q[{{ $q->id }}]"
									value="{{ $a->order_dsp }}">
							<span class="icon icmn-radio-unchecked"></span>
								{{ $a->content }}
						</label>
					@endforeach
					</div>
				@endif
				</div>
			</section>
		@endforeach
	</div>
	
	<div id="positionAndTime" style="display: none">
		<div class="row">
			<div class="question col-md-12">
				<label style="padding-left: 8px;">Địa điểm</label>
			</div>
		</div>	
		<div class="row row-address">
			<div class="answer col-md-6 col-sm-6 col-xs-6">
				<select id="ddCity" class="form-control"
						name="city">
					<option value="" selected disabled>Thành phố / Tỉnh</option>
					@foreach ($cities as $city)
						<option value="{{ $city->code }}">{{ $city->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="answer col-md-6 col-sm-6 col-xs-6" style="padding-left: 5px;">
				<select id="ddDist" class="form-control"
						name="dist"
						data-validation-message="Chưa chọn Quận / Huyện"
						data-validation="[NOTEMPTY]">
					<option value="" selected>Quận / Huyện</option>
				</select>
			</div>
		</div>
		<div class="row row-address">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<input type="text" class="form-control"
					placeholder="Địa chỉ"
					name="address"
					data-validation-message="Chưa nhập Địa chỉ"
					data-validation="[NOTEMPTY]">
			</div>
		</div>
		<div class="row">
			<div class="question form-group col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">
				<label id="lbTime">Thời gian</label>
			</div>
		</div>
		<div class="btn-group row" data-toggle="buttons">
			<label class="btn btn-default-outline row">
				<input type="radio" name="time" value="0"
					data-validation="[NOTEMPTY]"
					data-validation-group="lbTime"
					data-validation-message="Chưa chọn thời gian">
				<span class="icon icmn-radio-unchecked"></span>
					Càng sớm càng tốt
			</label>
			<label class="label-other btn btn-default-outline row">
				<input type="radio" name="time" value="1"
					data-validation-group="lbTime">
				<span class="icon icmn-radio-unchecked"></span>
				<input class="datetimepicker input-other" style="min-width: 80%"
						placeholder="Ấn định thời gian"
						type="text"
						name="estTime">
			</label>
		</div>
		<div class="row row-complete">
			<button id="btnBack" type="button" class="btn btn-secondary width-150">Quay lại</button>
			<button id="btnSubmit" type="submit" class="btn btn-primary width-150">Hoàn tất & Tìm thợ</button>
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</div>
	</div>
	</form>
</section>
@endsection