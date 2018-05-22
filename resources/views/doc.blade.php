@extends('template.index') @push('stylesheets')
<style>
body.single-page {
	background-color: #fff;
}
</style>
<script>
$(document).ready(function() {
});
</script>
@endpush @section('title') {{ $doc->title }} @endsection @section('content')
<section class="doc-section content-width-900 has-bottom-menu">
	<div class="doc-title text-center">{{ $doc->title }}</div>
	<div class="doc-content">{!! $doc->content !!}</div>
</section>
@endsection
@include('template.mb.footer-menu')