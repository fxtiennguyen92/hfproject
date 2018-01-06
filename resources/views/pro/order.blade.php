@extends('template.index')

@push('stylesheets')

@endpush

@section('title')

@endsection

@section('content')
<section class="page-content">
	@foreach ($order->requirements as $req)
		<strong>{{ $req->q_c }}</strong>
		@if (is_array($req->a_c))
			@foreach ($req->a_c as $info)
			<span>{{ $info }}</span>
			@endforeach
		@else
			<span>{{ $req->a_c }}</span>
		@endif
	@endforeach
	
	<form id="frmMain" method="POST" action="{{ route('quote_price') }}">
		@if ($quotedPrice)
		<input name="price" value="{{ $quotedPrice->price }}">
		@else
		<input name="price">
		@endif
	
		<button id="btnSubmit" type="submit" class="btn btn-primary width-150">
			@if ($quotedPrice)
			Báo giá lại
			@else
			Báo giá
			@endif
		</button>
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>
</section>
@endsection