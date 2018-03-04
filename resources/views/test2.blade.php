@extends('template.index') @push('stylesheets')
<script>


</script>
@endpush @section('title') Trang điều khiển @endsection @section('content')
<section class="content-body">
  <div class="nav-tabs-horizontal orders-page">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="javascript: void(0);" data-toggle="tab" data-target="#history" role="tab" aria-expanded="true">Lịch sử</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="javascript: void(0);" data-toggle="tab" data-target="#upcoming" role="tab" aria-expanded="false">Hiện tại</a>
      </li>
    </ul>
    <div class="tab-content padding-vertical-20">
      <div class="tab-pane active" id="history" role="tabpanel" aria-expanded="true">
        <div class="row">
          <div class="col-md-3 col-sm-6">
            <div class="orders-item hf-card">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
                  <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
                  <div class="author-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4><span class="label label-warning ">Đang thực hiện</span></h4>
                  <span class="post-date">
                    <time class="entry-date">Ngày mai lúc 8:30AM</time>
                  </span>
                  <div class="code-item margin-top-10">Đơn #021S32</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-top-20" style="border-top:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="service-icon">
                    <i class="material-icons">&#xE90F;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="service-title text-uppercase">Sửa điện</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-bottom-20" style="border-bottom:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="map-icon">
                    <i class="material-icons">&#xE0C8;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="map-address"><span>225 Cách Mạng tháng 8</span> Phường 4 quận 3 HCM</div>
                </div>
              </div>
              <div class="flex margin-top-20">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="price">300.000đ</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Gọi đối tác</button>
                </div>
              </div>

            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="orders-item hf-card">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
                  <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
                  <div class="author-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4><span class="label label-warning ">Đang thực hiện</span></h4>
                  <span class="post-date">
                    <time class="entry-date">Ngày mai lúc 8:30AM</time>
                  </span>
                  <div class="code-item margin-top-10">Đơn #021S32</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-top-20" style="border-top:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="service-icon">
                    <i class="material-icons">&#xE90F;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="service-title text-uppercase">Sửa điện</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-bottom-20" style="border-bottom:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="map-icon">
                    <i class="material-icons">&#xE0C8;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="map-address"><span>225 Cách Mạng tháng 8</span> Phường 4 quận 3 HCM</div>
                </div>
              </div>
              <div class="flex margin-top-20">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="price">300.000đ</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Gọi đối tác</button>
                </div>
              </div>

            </div>
          </div>
          <div class="col-md-3 col-sm-6">
            <div class="orders-item hf-card">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
                  <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
                  <div class="author-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4><span class="label label-warning ">Đang thực hiện</span></h4>
                  <span class="post-date">
                    <time class="entry-date">Ngày mai lúc 8:30AM</time>
                  </span>
                  <div class="code-item margin-top-10">Đơn #021S32</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-top-20" style="border-top:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="service-icon">
                    <i class="material-icons">&#xE90F;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="service-title text-uppercase">Sửa điện</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-bottom-20" style="border-bottom:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="map-icon">
                    <i class="material-icons">&#xE0C8;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="map-address"><span>225 Cách Mạng tháng 8</span> Phường 4 quận 3 HCM</div>
                </div>
              </div>
              <div class="flex margin-top-20">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="price">300.000đ</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Gọi đối tác</button>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
      <div class="tab-pane" id="upcoming" role="tabpanel" aria-expanded="false">
        <div class="row">

          <div class="col-md-3 col-sm-6">
            <div class="orders-item hf-card">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="author-avt"><img src="img/landing-page/avatar-2.png" /></div>
                  <div class="author-name margin-top-10">Ngô Tấn Đạt</div>
                  <div class="author-rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <h4><span class="label label-warning ">Đang thực hiện</span></h4>
                  <span class="post-date">
                    <time class="entry-date">Ngày mai lúc 8:30AM</time>
                  </span>
                  <div class="code-item margin-top-10">Đơn #021S32</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-top-20" style="border-top:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="service-icon">
                    <i class="material-icons">&#xE90F;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="service-title text-uppercase">Sửa điện</div>
                </div>
              </div>
              <div class="flex margin-top-20 padding-bottom-20" style="border-bottom:solid 1px #e1e1e1;">
                <div class="col-md-4 col-sm-4 col-xs-4 text-center">
                  <div class="map-icon">
                    <i class="material-icons">&#xE0C8;</i>
                  </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8 text-center">
                  <div class="map-address"><span>225 Cách Mạng tháng 8</span> Phường 4 quận 3 HCM</div>
                </div>
              </div>
              <div class="flex margin-top-20">
                <div class="col-md-6 col-sm-6 col-xs-6 text-center">
                  <div class="price">300.000đ</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <button type="button" class="btn btn-squared btn-primary margin-inline text-uppercase">Gọi đối tác</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
