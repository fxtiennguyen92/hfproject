<div style="margin-right:0; padding:0">
  @if (!$quotedPrice)
  <form class="quoted-form" id="frmQuotedPrice" name="form-validation" method="POST" action="{{ route('quote_price') }}">
    <input name="inpPrice" class="inp-quoted-price" value="100000" step="5000" min="100000" max="">
    <input name="price" class="basic-inp-quoted-price" type="hidden" />

    <div class="quoted-intro">
    <textarea class="form-control" name="introduction" rows="6" maxlength="200" placeholder="Ghi chú"></textarea>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
  @else
  @endif
</div>
