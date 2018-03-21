@extends('template.index') @push('stylesheets')
<style>
  @media only screen and (max-width: 500px) {
    .top-menu {
      display: none;
    }
  }

</style>
<script>


</script>
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body content-width-700">
  <div class="padding-top-20 hf-card pro-profile" style="margin-right:0; min-height:560px;">
    <div class="row">
      <div class="col-md-6">
        <div class="flex row">
          <div class="col-md-5 col-sm-5 col-xs-5 service-info text-center">
            <img style="border-radius:100%" class="avt" src="{{ env('CDN_HOST') }}/u/{{ $pro->id }}/{{ $pro->avatar }}">
          </div>
          <div class="col-md-7 col-sm-7 col-xs-7">
            <h4 class="pro-name text-bold">{{ $pro->name }}</h4>
            <div class="order-address margin-top-10">{{ $pro->profile->address }}</div>
            <div class="order-tag margin-top-10">
              @foreach ($pro->services as $key => $service)@if ($key != 0), @endif {{ $service->name }}@endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="text-center col-md-6">
        <div class="row skill-rating text-center padding-20">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-4">
              <span class="btn btn-info-outline hf-rounded">{{ $pro->profile->total_orders }}</span>
              <div>Đơn hàng</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <span class="btn btn-info hf-rounded">{{ $pro->profile->rating }}</span>
              <div>Đánh giá</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
              <span class="btn btn-info hf-rounded">{{ $pro->profile->total_review }}</span>
              <div>Nhận xét</div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="text-center padding-20 btn-book-border">
      <button type="button" class="btn-book btn btn-primary-outline">Chọn đối tác này</button>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="project padding-20">
          <div class=" row">
            <h5>Dự án đã thực hiện</h5>
            @if ($pro->profile->total_orders == 0)
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="common-text">Chưa có hình ảnh</div>
            </div>
            @else
            <div class="col-md-6 col-sm-6 col-xs-6 margin-bottom-15">
              <img src="img/landing-page/avatar-1.png">
            </div>
            @endif
          </div>
          @if ($pro->profile->total_orders > 0)
          <div class="text-center"><a href="#">Xem tất cả</a></div>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        <div class="comment padding-20">
          <h5>Nhận xét @if ($pro->profile->total_review > 0) ({{ $pro->profile->total_review }}) @endif</h5>
          @if ($pro->profile->total_review == 0)
          <div class="row">
            <div class="common-text">Chưa có nhận xét</div>
          </div>
          @else @foreach ($pro->reviews as $review)
          <div class="message row">
            <div class=" col-md-2 col-sm-2 col-xs-2 text-center">
              <img class="avatar" style="border-radius:100%" class="avt" src="{{ env('CDN_HOST') }}/u/{{ $review->user->id }}/{{ $review->user->avatar }}">
            </div>
            <div class="col-md-10 col-sm-10 col-xs-10">
              <div class="clearfix">
                <div class="pull-left author"><a href="#">{{ $review->user->name }}</a> <span>{{ $review->created_at->format('d/m/Y') }}</span></div>
                <div class="author-rating pull-right">
                  <select id="rating" class="rating" data-current-rating="{{ $review->rating }}">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
              </div>
              <div class="message-text">
                {{ $review->content }}
              </div>
            </div>
          </div>
          @endforeach @endif @if ($pro->profile->total_review > 10)
          <div class="text-center"><a href="#">Xem tất cả</a></div>
          @endif
        </div>
      </div>
    </div>
    <div class="text-center">
      <button type="button" class="mb-btn-book">Chọn đối tác này</button>
    </div>
  </div>
</section>
@endsection
