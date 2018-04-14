<div style="margin-right:0; padding:0">
  @if (!$quotedPrice)
  <form class="quoted-form" id="frmQuotedPrice" name="form-validation" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="inp-quoted-price" value="100000" step="5000" min="100000" max="">
    <input name="price" class="basic-inp-quoted-price" type="hidden"/>
    <div class="text-light padding-top-20 text-left" style="padding-left: 10px;">Vào lúc</div>
    <div class="row excute-date">
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
    <div class="quoted-intro padding-top-20">
    <textarea class="form-control" name="introduction" rows="6" maxlength="200" placeholder="Ghi chú"></textarea>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
  @elseif ($order->state == 0)
  
  @else
</div>
