@extends('template.mng.index')
@push('stylesheets')
<style>
</style>

<!-- Page Scripts -->
<script>
	$(document).ready(function() {
		@if (session('error'))
			swal({
				title: 'Thất bại',
				text: '{{ session("error") }}',
				type: 'error',
				confirmButtonClass: 'btn-default',
				confirmButtonText: 'Quay lại',
			});
		@endif
		
		$('.mng-list').DataTable({
			responsive: true,
			info: false,
			paging: false,
			sorting: false,
			language: {
				zeroRecords: "Chưa có thông tin",
				search: "Tìm kiếm"
			},
			columnDefs: [ { orderable: false, targets: [0,1,2,3] } ]
		});
		
		$('#frmQuestion').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						loadingBtnSubmit('btnSubmitQuestion');
						
						$.ajax({
							type: 'POST',
							url: $('#frmQuestion').attr('action'),
							data: $('#frmQuestion').serialize(),
							success: function(question) {
								location.href = '{{ route("mng_survey_list", ["id" => $service->id]) }}';
							},
							error: function(xhr) {
								resetBtnSubmit('btnSubmitQuestion', 'Cập nhật');
								
								swal({
									title: 'Xử lý thất bại',
									text: 'Vui lòng thử lại.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							}
						});
					}
				}
			}
		});
		
		$('#frmAnswer').validate({
			submit: {
				settings: {
					inputContainer: '.form-group',
					errorListClass: 'form-control-error',
					errorClass: 'has-danger',
				},
				callback: {
					onSubmit: function() {
						loadingBtnSubmit('btnSubmitAnswer');
						
						$.ajax({
							type: 'POST',
							url: $('#frmAnswer').attr('action'),
							data: $('#frmAnswer').serialize(),
							success: function(question) {
								location.href = '{{ route("mng_survey_list", ["id" => $service->id]) }}';
							},
							error: function(xhr) {
								resetBtnSubmit('btnSubmitAnswer', 'Cập nhật');
								
								swal({
									title: 'Xử lý thất bại',
									text: 'Vui lòng thử lại.',
									type: 'error',
									confirmButtonClass: 'btn-default',
									confirmButtonText: 'Quay lại',
								});
							}
						});
					}
				}
			}
		});
	});

	function resetModalQuestion() {
		$('#frmQuestion input[name=content]').val('');
		$('#frmQuestion input[name=short_content]').val('');
		$('#frmQuestion input[name=order_dsp]').val(0);
		$('#frmQuestion select[name=answer_type]').val(1);
		$('#frmQuestion select[name=answer_type]').selectpicker('refresh');
	}

	function resetModalAnswer() {
		$('#frmAnswer input[name=content]').val('');
		$('#frmAnswer input[name=order_dsp]').val(0);
		$('#frmAnswer select[name=other_flg]').val(0);
		$('#frmAnswer select[name=other_flg]').selectpicker('refresh');
	}

	function newQuestion() {
		resetModalQuestion();
		
		$('#frmQuestion').attr('action', '{{ route("mng_survey_question_create", ["id" => $service->id]) }}');
		
		$('#modalQuestion').modal('show');
		$('#frmQuestion input[name=content]').focus();
	}

	function newAnswer(id) {
		resetModalAnswer();

		var creUrl = '{{ route("mng_survey_answer_create", ["id" => "questionId"]) }}';
		creUrl = creUrl.replace('questionId', id);
		$('#frmAnswer').attr('action', creUrl);
		
		$('#modalAnswer').modal('show');
		$('#frmAnswer input[name=content]').focus();
	}

	function editQuestion(id) {
		resetModalQuestion();
		
		var updUrl = '{{ route("mng_survey_question_update", ["id" => "questionId"]) }}';
		updUrl = updUrl.replace('questionId', id);
		$('#frmQuestion').attr('action', updUrl);
		
		loadingBtnSubmit('btnSubmitQuestion');
		$('#modalQuestion').modal('show');
		
		var url = '{{ route("mng_survey_question_edit", ["id" => "questionId"]) }}';
		url = url.replace('questionId', id);
		$.ajax({
			type: 'GET',
			url: url,
			success: function(question) {
				$('#frmQuestion input[name=content]').val(question['content']);
				$('#frmQuestion input[name=short_content]').val(question['short_content']);
				$('#frmQuestion input[name=order_dsp]').val(question['order_dsp']);
				$('#frmQuestion select[name=answer_type]').val(question['answer_type']);
				$('#frmQuestion select[name=answer_type]').selectpicker('refresh')
				
				resetBtnSubmit('btnSubmitQuestion', 'Cập nhật');
			},
			error: function(xhr) {
				$('#modalQuestion').modal('toggle');
				resetBtnSubmit('btnSubmitQuestion', 'Cập nhật');
				
				swal({
					title: 'Không tải được dữ liệu',
					text: 'Vui lòng thử lại.',
					type: 'error',
					confirmButtonClass: 'btn-default',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	}

	function editAnswer(id) {
		resetModalAnswer();
		
		var updUrl = '{{ route("mng_survey_answer_update", ["id" => "answerId"]) }}';
		updUrl = updUrl.replace('answerId', id);
		$('#frmAnswer').attr('action', updUrl);
		
		loadingBtnSubmit('btnSubmitAnswer');
		$('#modalAnswer').modal('show');
		
		var url = '{{ route("mng_survey_answer_edit", ["id" => "answerId"]) }}';
		url = url.replace('answerId', id);
		$.ajax({
			type: 'GET',
			url: url,
			success: function(answer) {
				$('#frmAnswer input[name=content]').val(answer['content']);
				$('#frmAnswer input[name=order_dsp]').val(answer['order_dsp']);
				$('#frmAnswer select[name=other_flg]').val(answer['other_flg']);
				$('#frmAnswer select[name=other_flg]').selectpicker('refresh')
				
				resetBtnSubmit('btnSubmitAnswer', 'Cập nhật');
			},
			error: function(xhr) {
				$('#modalAnswer').modal('toggle');
				resetBtnSubmit('btnSubmitAnswer', 'Cập nhật');
				
				swal({
					title: 'Không tải được dữ liệu',
					text: 'Vui lòng thử lại.',
					type: 'error',
					confirmButtonClass: 'btn-default',
					confirmButtonText: 'Quay lại',
				});
			}
		});
	}

	function deleteQuestion(id) {
		swal({
			title: 'Xóa Câu hỏi?',
			text: 'Câu trả lời của câu hỏi này cũng sẽ bị xóa.',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
		},
		function(){
			var url = '{{ route("mng_survey_question_delete", ["id" => "questionId"]) }}';
			url = url.replace('questionId', id);
			$.ajax({
				type: 'POST',
				url: url,
				data: $('#frmQuestion').serialize(),
				success: function(question) {
					swal({
						title: 'Hoàn thành',
						text: 'Đã xóa thành công',
						type: 'success',
						confirmButtonClass: 'btn-success',
						confirmButtonText: 'Quay lại',
					},
					function() {
						location.href = '{{ route("mng_survey_list", ["id" => $service->id]) }}';
					});
				},
				error: function(xhr) {
					swal({
						title: 'Thất bại',
						text: 'Vui lòng thử lại',
						type: 'error',
						confirmButtonClass: 'btn-default',
						confirmButtonText: 'Quay lại',
					});
				}
			});
		});
	}

	function deleteAnswer(id) {
		swal({
			title: 'Xóa Câu trả lời?',
			text: 'Câu trả lời bị xóa sẽ không thể phục hồi.',
			type: 'warning',
			showCancelButton: true,
			cancelButtonClass: 'btn-default',
			confirmButtonClass: 'btn-danger',
			cancelButtonText: 'Quay lại',
			confirmButtonText: 'Xóa',
		},
		function(){
			var url = '{{ route("mng_survey_answer_delete", ["id" => "answerId"]) }}';
			url = url.replace('answerId', id);
			$.ajax({
				type: 'POST',
				url: url,
				data: $('#frmAnswer').serialize(),
				success: function(question) {
					swal({
						title: 'Hoàn thành',
						text: 'Đã xóa thành công',
						type: 'success',
						confirmButtonClass: 'btn-success',
						confirmButtonText: 'Quay lại',
					},
					function() {
						location.href = '{{ route("mng_survey_list", ["id" => $service->id]) }}';
					});
				},
				error: function(xhr) {
					swal({
						title: 'Thất bại',
						text: 'Vui lòng thử lại',
						type: 'error',
						confirmButtonClass: 'btn-default',
						confirmButtonText: 'Quay lại',
					});
				}
			});
		});
	}
</script>
@endpush

@section('title') Câu hỏi khảo sát @endsection

@section('content')
<section class="content-body-full-page content-template-1">
	<div class="page-header hf-bg-gradient text-capitalize">Câu hỏi Khảo sát</div>
	<div class="form-wrapper">
		<div class="row">
			<div class="col-xs-6">
				<i class="margin-right-5 icmn-cog"></i><b>{{ $service->name }}</b>
			</div>
			<div class="col-xs-6 text-right">
				<button class="btn btn-primary" type="button" onclick="newQuestion();">
					<i class="material-icons">playlist_add</i></button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover nowrap mng-list" width="100%">
					<thead>
						<tr>
							<th>Câu hỏi / Câu trả lời</th>
							<th>Câu hỏi ngắn</th>
							<th>Kiểu trả lời</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($survey as $question)
						<tr>
							<td><b>{{ $question->order_dsp }}. {{ $question->content }}</b></td>
							<td>{{ $question->short_content }}</td>
							<td>
								@if ($question->answer_type == 1)
								<i class="margin-right-5 icmn-checkbox-checked"></i> Được chọn nhiều
								@elseif ($question->answer_type == 2)
								<i class="margin-right-5 icmn-radio-checked"></i> Chỉ chọn một
								@else
								<i class="margin-right-5 icmn-pencil"></i> Tự nhập liệu
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);" onclick="editQuestion({{ $question->id }})">
											<i class="icmn-pencil7"></i> Chỉnh sửa
										</a>
										<a class="dropdown-item @if ($question->answer_type == 0) hide @endif" href="javascript:void(0);" onclick="newAnswer({{ $question->id }})">
											<i class="icmn-bubble-plus"></i> Thêm câu trả lời
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="deleteQuestion('{{ $question->id }}')">
											<i class="icmn-lock"></i> Xóa
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@foreach ($question->answers as $answer)
						<tr>
							<td>
								<span class="padding-left-20">{{ $question->order_dsp }}.{{ $answer->order_dsp }}. {{ $answer->content }}</span>
							</td>
							<td>&nbsp;</td>
							<td>
								@if ($answer->other_flg == 1)
								<i class="icmn-pencil"></i> Tự nhập liệu
								@endif
							</td>
							<td class="text-right">
								<div class="dropdown">
									<span class="btn btn-sm" data-toggle="dropdown">
									<i class="icmn-cog3"></i>
									</span>
									<ul class="dropdown-menu dropdown-menu-right" role="menu">
										<a class="dropdown-item" href="javascript:void(0);" onclick="editAnswer({{ $answer->id }})">
											<i class="icmn-pencil7"></i> Chỉnh sửa
										</a>
										<a class="dropdown-item" href="javascript:void(0);" onclick="deleteAnswer({{ $answer->id }})">
											<i class="icmn-lock"></i> Xóa
										</a>
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<form id="frmMain" method="post" enctype="multipart/form-data" action="">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		</form>
	</div>
	
	<div id="modalQuestion" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmQuestion" method="post" name="form-validation" enctype="multipart/form-data" action="">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper" style="padding-bottom: 10px;">
							<h1 class="page-title text-left">Câu hỏi khảo sát</h1>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Nội dung câu hỏi</label>
										<input type="text" maxlength="225" class="form-control" name="content" data-validation="[NOTEMPTY]">
									</div>
								</div>
								<div class="col-md-5 col-sm-12">
									<div class="form-group">
										<label>Câu hỏi ngắn</label>
										<input type="text" maxlength="150" class="form-control" style="padding-bottom: 12px;"
											name="short_content" data-validation="[NOTEMPTY]">
									</div>
								</div>
								<div class="col-md-2 col-sm-12">
									<div class="form-group">
										<label>Thứ tự</label>
										<input type="text" maxlength="150" class="form-control text-center" style="padding-bottom: 12px;"
											name="order_dsp" value="0" data-validation="[INTEGER]">
									</div>
								</div>
								<div class="col-md-5 col-sm-12">
									<div class="form-group">
										<label>Kiểu trả lời</label>
										<select class="form-control selectpicker hf-select" data-live-search="true" name="answer_type">
											<option value="1">Được chọn nhiều</option>
											<option value="2">Chỉ chọn một</option>
											<option value="0">Tự nhập liệu</option>
										</select>
									</div>
								</div>
							</div>
							<div class="margin-top-30 text-right">
								<button id="btnSubmitQuestion" type="submit" class="btn btn-primary width-150">Cập nhật</button>
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div id="modalAnswer" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form id="frmAnswer" method="post" name="form-validation" enctype="multipart/form-data" action="">
				<div class="modal-content">
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="form-wrapper" style="padding-bottom: 10px;">
							<h1 class="page-title text-left">Câu trả lời</h1>
							<div class="row">
								<div class="col-sm-10">
									<div class="form-group">
										<label>Kiểu trả lời</label>
										<select class="form-control selectpicker hf-select" data-live-search="true" name="other_flg">
											<option value="0">Click chọn</option>
											<option value="1">Tự nhập liệu</option>
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label>Thứ tự</label>
										<input type="text" maxlength="150" class="form-control text-center" style="padding-bottom: 12px;"
											name="order_dsp" value="0" data-validation="[INTEGER]">
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label>Nội dung câu trả lời</label>
										<input type="text" maxlength="225" class="form-control" name="content" data-validation="[NOTEMPTY]">
									</div>
								</div>
							</div>
							<div class="margin-top-30 text-right">
								<button id="btnSubmitAnswer" type="submit" class="btn btn-primary width-150">Cập nhật</button>
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

@endsection
