<div style="margin-right:0; padding:0">
  @if (!$quotedPrice)
  <form class="quoted-form" id="frmQuotedPrice" name="form-validation" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="inp-quoted-price" value="100000" step="5000" min="100000" max="">
    <input name="price" class="basic-inp-quoted-price" type="hidden"/>
    <div class="padding-top-10 color-danger text-left" style="font-size: 13px">Giá trên là số tiền bạn thu của Khách</div>
    <div class="padding-bottom-10 color-danger text-left" style="font-size: 13px">Tiền Chiết khấu trả cho Hand Free là <span id="spanCK" style="font-weight: bold">17.000 đ</span></div>
    <div class="text-light padding-top-20 text-left" style="padding-left: 10px; display: none;">Vào lúc</div>
    <div class="row excute-date" style="display: none;">
      <div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 0; padding-right: 0">
        <select class="form-control selectpicker hf-select hf-select-date" data-live-search="false" name="estDate">
        @foreach ($dates as $date)
          <option value="{{ $date }}">{{ $date }}</option>
        @endforeach
        </select>
      </div>
      <div class="col-md-4 col-sm-4 col-xs-4" style="padding-right: 0">
        <select class="form-control selectpicker hf-select hf-select-time" data-live-search="false" name="estTime">
        @foreach ($times as $time)
          <option value="{{ $time }}">{{ $time }}</option>
        @endforeach
        </select>
      </div>
    </div>
    <div class="padding-top-20">
    <textarea class="form-control" name="introduction" rows="6" maxlength="200" placeholder="Mô tả dịch vụ của bạn"></textarea>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
  @elseif ($order->state == 0)
  <div class="common-text color-danger">Đã báo giá đơn hàng này</div>
  <div class="padding-10 text-center hf-card user-row">
    <div class="color-primary price" style="font-size: 26px; font-weight: bold;">{{ $quotedPrice->price }}</div>
    @if ($quotedPrice->est_excute_at_string)
    <div class="color-primary" style="font-size: 14px">{{ $quotedPrice->est_excute_at_string }}</div>
    @endif
  </div>
  @elseif ($order->state == 1)
  <div class="common-text color-primary">Báo giá thành công, đơn hàng đang đợi thực hiện</div>
  <div class="row">
    <div class="col-md-12">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{ Carbon\Carbon::parse($order->est_excute_at)->format('H:i') }}</h3>
            <progress class="progress progress-primary" value="75" max="100"></progress>
          </div>
        </div>
    </div>
  </div>
  @elseif ($order->state == 2)
  <div class="common-text color-primary">Đơn hàng đang được thực hiện</div>
  @elseif ($order->state == 3)
  <div class="common-text color-success">Đơn hàng đã hoàn tất</div>
  @elseif ($order->state == 4)
  <div class="common-text color-danger">Đơn hàng đã hủy</div>
  @endif
</div>
