@extends('template.index')

@push('stylesheets')
	<!-- Page Scripts -->
	<script>
	$(document).ready(function() {
		$('#surveyList').steps({
			headerTag: 'h3',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			autoFocus: true
		});
	});
	</script>
@endpush

@section('title')
	Thông Tin Sự Cố
@endsection

@section('content')
<section class="page-content">
	<form method="POST" action="{{ route('submit_order_details') }}">
	<div id="surveyList" class="cui-wizard cui-wizard__numbers">
		@foreach ($questions as $q)
			<h3><span class="cui-wizard--steps--title"></span></h3>
			<section class="text-center">
				<div style="width: 700px; margin: auto">
				{{ $q->content }}
				@if ($q->answer_type == '0')
					<input type="text" class="form-control" name="q[{{ $q->id }}]">
				@elseif ($q->answer_type == '1')
					@foreach ($q->answers as $a)
					<div class="form-group" style="text-align: left">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="q[{{ $q->id }}]" value="a[{{ $a->id }}]">
								{{ $a->content }}
							</label>
						</div>
					</div>
					@endforeach
				@elseif ($q->answer_type == '2')
					@foreach ($q->answers as $a)
					<div class="form-group">
						<div class="radio">
							<label>
								<input type="radio" name="example1" checked="">
								{{ $a->content }}
							</label>
						</div>
					</div>
					@endforeach
				@elseif ($q->answer_type == '3')
					<div class="form-group">
						<select class="form-control">
							@foreach ($q->answers as $a)
							<option>{{ $a->content }}</option>
							@endforeach
						</select>
					</div>
				@endif
				</div>
			</section>
		@endforeach
	</div>
	</form>
</section>
@endsection