<div id="clockdiv">
	<div class="hours">
		<span></span>
		<div class="smalltext">Giờ</div>
	</div>
	<div class="minutes">
		<span class="minutes"></span>
		<div class="smalltext">Phút</div>
	</div>
	<div class="seconds">
		<span></span>
		<div class="smalltext">Giây</div>
	</div>
</div>
<script>
countdown('{{ $order->est_excute_at }}','{{ date("Y/m/d H:i:s") }}');
</script>