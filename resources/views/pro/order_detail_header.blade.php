<div class="order-info hf-card margin-bottom-20" style="margin-right:0; padding:0">
  <div class="padding-20">
    <div class="flex">
      <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
        <img class="avt" style="border-radius: 100%" src="{{ env('CDN_HOST') }}/u/{{ $order->user->id }}/{{ $order->user->avatar }}">
        <label class="order-user">{{ $order->user->name }}</label>
      </div>
      <div class="col-md-7 col-sm-7 col-xs-7">
        <div class="order-code">#{{ $order->no }}</div>
        <div class="order-service-content"><i class="material-icons">&#xE869;</i> {{ $order->service->name }}</div>
        <div class="order-address" title="{{ $order->address }}"><i class="material-icons">&#xE0C8;</i> {{ $order->address }}</div>
        <div class="order-state">
          @if ($order->est_excute_at_string)
          <span class="order-time state-est-time"><i class="material-icons">&#xE855;</i> {{ $order->est_excute_at_string }}</span> @else
          <span class="order-time state-now"><i class="material-icons">&#xE3E7;</i> Ngay lập tức</span> @endif
        </div>
      </div>
    </div>
  </div>
</div>