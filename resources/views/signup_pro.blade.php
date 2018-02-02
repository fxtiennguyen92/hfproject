@extends('template.index') @push('stylesheets')
<script src="assets/vendors/angular/angular.min.js"></script>
<script src="assets/vendors/img-crop/ng-img-crop.js"></script>
<style>
  nav.top-menu {
    display: none;
  }

  body {
    background: #f4f4f4;
  }

  nav.top-menu+.page-content {
    margin-top: 0;
  }

</style>

<!-- Page Scripts -->
<script>
  $(document).ready(function() {
    <!-- Initial - STA -->
    @if(isset($profile))
    $('input[name=dateOfBirth]').val("{{ Carbon\Carbon::parse($profile->date_of_birth)->format('d-m-Y') }}");
    $('select[name=gender]').val("{{ $profile->gender }}");
    @endif

    <!-- Avatar - STA -->
    $('#fileInput').on('change', function() {
      $('#btnSaveImage').show();
    });
    $('#btnSaveImage').on('click', function() {
      $('#avatar').val($('#image_avatar').attr('ng-src'));
    });
    <!-- Avatar - END -->

    $('#dpDateOfBirth').datetimepicker({
      format: 'DD/MM/YYYY'
    });
    $('#dpDateOfBirth input').mask('00/00/0000');
    $('#inpPhone').mask('0000000000000');

    <!-- Autocomplete Companies - STA -->
    var path = "{{ route('get_companies') }}";
    $('#inpCompany').typeahead({
      minLength: 2,
      maxItem: 5,
      order: 'asc',
      source: function(request, response) {
        $.ajax({
          url: path,
          dataType: 'json',
          data: {
            term: $('#inpCompany').val(),
          },
          success: function(data) {
            response(data);
          }
        });
      },
      displayText: function(item) {
        return item.value;
      }
    });
    <!-- Autocomplete Companies - END -->
    $('#frmMain').validate({
      submit: {
        settings: {
          inputContainer: '.form-group',
          errorListClass: 'form-control-error',
          errorClass: 'has-danger',
        },
        callback: {
          onSubmit: function() {
            $.ajax({
              type: 'POST',
              url: '{{ route("change_pro_profile") }}',
              data: $('#frmMain').serialize(),
              success: function(response) {
                $.notify({
                  title: '<strong>Hoàn tất! </strong>',
                  message: 'Thông tin cá nhân đã thay đổi thành công.'
                }, {
                  type: 'success',
                  z_index: 1051,
                });

                setTimeout(function() {
                  location.reload();
                }, 1500);
              },
              error: function(xhr) {
                if (xhr.status == 400) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Không có thông tin để thay đổi.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                } else {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Không thể Cập nhật thông tin cá nhân.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                };

                setTimeout(function() {
                  location.reload();
                }, 1500);
              }
            });
          }
        }
      }
    });

    $('#frmChangePassword').validate({
      submit: {
        settings: {
          inputContainer: '.form-group',
          errorListClass: 'form-control-error',
          errorClass: 'has-danger',
        },
        callback: {
          onSubmit: function() {
            $.ajax({
              type: 'POST',
              url: '{{ route("change_password") }}',
              data: $('#frmChangePassword').serialize(),
              success: function(response) {
                $.notify({
                  title: '<strong>Hoàn tất! </strong>',
                  message: 'Mật khẩu đã thay đổi thành công.'
                }, {
                  type: 'success',
                  z_index: 1051,
                });

                setTimeout(function() {
                  location.reload();
                }, 1500);
              },
              error: function(xhr) {
                if (xhr.status == 401) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Mật khẩu hiện tại chưa đúng.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                } else if (xhr.status == 400) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Mật khẩu mới giống Mật khẩu hiện tại.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                } else {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Thay đổi Mật khẩu thất bại.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });

                  setTimeout(function() {
                    location.reload();
                  }, 1500);
                };
              }
            });
          }
        }
      }
    });
  });

</script>

@endpush @section('title') @endsection @section('content')
<section class="page-content signup-pro">
  <div class="header-logo">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <a href="#"><img src="img/hf-logo.png" /></a>
      </div>
    </div>
  </div>

  <div class="col-md-2">
  </div>
  <div class="col-md-8">
    <form id="frmMain" class="form-wrapper hf-card" name="form-validation" method="post" enctype="multipart/form-data" action="{{ route('change_pro_profile') }}">
      <h1 class="page-title text-left">Thông tin Đối Tác</h1>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Họ tên</label>
            <input maxlength="200" class="form-control" placeholder="Họ và Tên" name="name" type="text" data-validation-message="Họ tên chưa được nhập" data-validation="[NOTEMPTY]" value="{{ auth()->user()->name }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Ngày tháng năm sinh</label>
            <div class='date' id='dpDateOfBirth'>
              <input type='text' class="form-control" name="dateOfBirth" />

            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Giới tính</label>
        <select class="form-control" name="gender">
				<option value="" disabled selected></option>
				<option value="1">Nam</option>
				<option value="2">Nữ</option>
				<option value="0">Khác</option>
			</select>
      </div>
      <div class="form-group">
        <label>Email</label>
        <div class="input-group">
          <input type="text" class="form-control" disabled value="{{ auth()->user()->email }}" name="email">
          <a class="input-group-addon" title="Thay đổi Email"><i class="icmn-envelop5"></i></a>
        </div>
      </div>
      <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" maxlength="25" class="form-control" value="{{ auth()->user()->phone }}" id="inpPhone" name="phone" placeholder="Số điện thoại">
      </div>
      <div class="form-group">
        <label>Mật khẩu</label>
        <div class="input-group">
          <input type="password" class="form-control" value="*********" disabled>
          <a class="input-group-addon" data-toggle="modal" data-target="#password-modal" title="Thay đổi Mật khẩu"><i class="icmn-cogs"></i></a>
        </div>
      </div>
      <div class="form-group">
        <label>Công ty</label>
        <div class="typeahead__container">
          <div class="typeahead__field">
            <div class="typeahead__query">
              <input class="form-control" type="text" placeholder="Công ty" autocomplete="off" id="inpCompany" name="company" />
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="text-align: right;">
        <button id="btnSubmit" type="submit" class="btn btn-primary width-150">Lưu lại</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      </div>
    </form>
  </div>

  <!-- MODAL -->

  <div id="password-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <form id="frmChangePassword" name="form-validation" method="post" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
            <h4 class="modal-title">Thay đổi Mật khẩu</h4>
          </div>
          <div class="modal-body">
            @if (auth()->user()->password)
            <div class="form-group">
              <label>Mật khẩu hiện tại</label>
              <input id="currPassword" name="currPassword" class="form-control password" type="password" data-validation="[L>=10]" data-validation-message="Mật khẩu có ít nhất là 10 ký tự" placeholder="Mật khẩu hiện tại">
            </div>
            @endif
            <div class="form-group">
              <label>Mật khẩu mới</label>
              <input id="newPassword" name="newPassword" class="form-control password" type="password" data-validation="[L>=10]" data-validation-message="Mật khẩu có ít nhất là 10 ký tự" placeholder="Mật khẩu mới">
            </div>
            <div class="form-group">
              <label>Xác nhận Mật khẩu mới</label>
              <input id="rePassword" name="rePassword" class="form-control password" type="password" data-validation="[V==newPassword]" data-validation-message="Xác nhận Mật khẩu mới chưa đúng" placeholder="Nhập lại Mật khẩu mới">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnChangePassword">Thay đổi</button>
            <button type="button" class="btn" data-dismiss="modal">Đóng lại</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
