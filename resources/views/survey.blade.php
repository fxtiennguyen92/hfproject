@extends('template.index') @push('stylesheets')
<!-- Page Scripts -->
<script>
  $(document).ready(function() {
    $('body').addClass('survey-page');
    $('#surveyList').steps({
      headerTag: 'h3',
      bodyTag: 'section',
      transitionEffect: 'slideLeft',
      autoFocus: true,
      enableAllSteps: true,
      labels: {
        finish: "<i class='material-icons'>&#xE315;</i>",
        next: "<i class='material-icons'>&#xE315;</i>",
        previous: "<i class='material-icons'>&#xE314;</i>",
      },
      onStepChanging: function(e, currentIndex, newIndex) {
        var validReturn = true;
        if (currentIndex < newIndex) {
          var name = $('section[id=surveyList-p-' + currentIndex + ']')
            .find('input:not([type=text],[type=button],[type=submit])')
            .first()
            .attr('name');
          if ($('input[name="' + name + '"]:checked').length == 0) {
            $.notify({
              message: 'Hãy chọn một nội dung bên dưới.'
            }, {
              type: 'danger',
            });

            validReturn = false;
          };

          var inpOther = $('section[id=surveyList-p-' + currentIndex + ']')
            .find('input.input-other');
          if ($.trim(inpOther.val()) == '' && inpOther.parent().hasClass('active')) {
            $.notify({
              message: 'Vui lòng cung cấp thông tin.'
            }, {
              type: 'danger',
            });
            inpOther.focus();
            validReturn = false;
          }
        }

        return validReturn;
      },
      onStepChanged: function(e, currentIndex, priorIndex) {
        var total = '{{ sizeof($questions) }}';
        var percent = (currentIndex) / total * 100;
        $('.progress-bar').css('width', percent + '%');
      },
    });
    $('label').on('click', function() {
      var span = $(this).find('span');
      if (span.hasClass('icmn-radio-unchecked')) {
        $(this).parent().find('span').each(function() {
          $(this).addClass('icmn-radio-unchecked').removeClass('icmn-checkmark-circle');
        });
        span.addClass('icmn-checkmark-circle').removeClass('icmn-radio-unchecked');

      } else if (span.hasClass('icmn-checkbox-unchecked2')) {
        span.addClass('icmn-checkbox-checked2').removeClass('icmn-checkbox-unchecked2');
      } else if (span.hasClass('icmn-checkbox-checked2')) {
        span.addClass('icmn-checkbox-unchecked2').removeClass('icmn-checkbox-checked2');
      }
    });
    $('.label-other').on('click', function() {
      if (!$(this).hasClass('active')) {
        $(this).find('.input-other').focus();
      }
    });
    $('a[href=#finish]').on('click', function() {
      $('#positionAndTime').show();
      $('#surveyList').hide();
      $('.progress-bar').css('width', '100%');
    });
    $('#btnBack').on('click', function() {
      $('#positionAndTime').hide();
      $('#surveyList').show();
    });
    $('.datetimepicker').datetimepicker({
      minDate: moment(),
      locale: moment.locale('vi'),
      format: 'dddd, DD/MM/YYYY HH:ss',
      showClose: true,
      widgetPositioning: {
        horizontal: 'auto',
        vertical: 'top'
      },
      icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-screenshot',
        clear: 'fa fa-trash',
        close: 'fa fa-check'
      },
    });
    $('.ddCity').on('change', function() {
      if ($(this).val() == '') {
        return false;
      }

      var ddDist = $('select.ddDist');
      ddDist.children('option').remove();

      var url = '{{ route("get_dist_by_city", ["code" => "cityCode"]) }}';
      url = url.replace('cityCode', $(this).val());
      $.ajax({
        url: url,
        success: function(data) {
          $.each(data, function(key, value) {
            ddDist.append($('<option></option>')
              .attr('value', value.code)
              .text(value.name));
          });
          ddDist.selectpicker('refresh');
        }
      });
    });

    $('.time-rad').on('click', function() {
      if ($(this).find('input').val() == 1) {
        $('#excuteDatetime').show();
      } else {
        $('#excuteDatetime').hide();
      }
    });
    
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
              url: '{{ route("submit_order") }}',
              data: $('#frmMain').serialize(),
              success: function(response) {
                swal({
                    title: 'Thành công',
                    text: 'Hoàn tất đơn hàng, vui lòng chờ báo giá !',
                    type: 'success',
                    confirmButtonClass: 'btn-primary',
                    confirmButtonText: 'Tiếp tục',
                  },
                  function() {
                    location.href = '{{ route("order_list_page") }}';
                  });
              },
              error: function(xhr) {
                if (xhr.status == 400) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Đã có lỗi xảy ra, mời chọn lại dịch vụ.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                  setTimeout(function() {
                    location.reload();
                  }, 1500);

                  location.href('{{ route("home_page") }}');
                } else if (xhr.status == 403) {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Thời gian thực hiện không đúng, mời chọn lại.'
                  }, {
                    type: 'danger',
                    z_index: 1051,
                  });
                } else {
                  $.notify({
                    title: '<strong>Thất bại! </strong>',
                    message: 'Không thể thực hiện đặt đơn hàng.'
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
@endpush @section('title') Đơn hàng @endsection @section('content')
<section class="content-body">
  <form id="frmMain" class="survey-form" name="form-validation" method="post" enctype="multipart/form-data">

    <div class="service-title" style="background-image:url('img/banner/6.png')">
      <span class="title"><img class="service-icon" src="img/service/{{ $service->id }}.svg" /> {{ $service->name }}</span>
    </div>
    <div class="progress">
      <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:10%"></div>
    </div>
    <div id="surveyList" class="cui-wizard cui-wizard__numbers">
      @foreach ($questions as $q)
      <h3><span class="cui-wizard--steps--title"></span></h3>
      <section>
        <div class="question">
          {{ $q->content }}
        </div>
        <div class="answer">
          @if ($q->answer_type == '0')
          <div>
            <textarea style="margin:0;padding:10px;" class="no-newlines form-control" name="q[{{ $q->id }}]" rows="6" maxlength="100" placeholder="Ghi chú"></textarea>
          </div>
          @elseif ($q->answer_type == '1')
          <div data-toggle="buttons">
            @foreach ($q->answers as $a) @if ($a->init_flg == 2)
            <label class="label-other btn">
              <input type="checkbox"
                  name="q[{{ $q->id }}][]"
                  value="{{ $a->order_dsp }}">
              <span class="icon icmn-checkbox-unchecked2"></span>
              
              <input class="input-other" type="text"
                  placeholder="{{ $a->content }}"
                  name="{{ $q->id.'_'.$a->order_dsp }}_text"
                  value="">
            </label> @else
            <label class="btn">
              <input type="checkbox"
                  name="q[{{ $q->id }}][]"
                  value="{{ $a->order_dsp }}">
              <span class="icon icmn-checkbox-unchecked2"></span>
                {{ $a->content }}
            </label> @endif @endforeach
          </div>
          @elseif ($q->answer_type == '2')
          <div class="btn-group" data-toggle="buttons">
            @foreach ($q->answers as $a)
            <label class="btn">
              <input type="radio"
                  name="q[{{ $q->id }}]"
                  value="{{ $a->order_dsp }}">
              <span class="icon icmn-radio-unchecked"></span>
                {{ $a->content }}
            </label> @endforeach
          </div>
          @endif
        </div>
      </section>
      @endforeach
    </div>

    <div id="positionAndTime" style="display: none">
      <div class="content clearfix">
        <div class="address">
          Địa điểm và Thời gian
        </div>
        <div class="address-wrapper">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input type="text" class="form-control" placeholder="Nhập Số Nhà. VD: 20/7 Hai Bà Trưng" name="address" data-validation="[NOTEMPTY]">
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0; padding-right: 0">
                <select class="form-control selectpicker ddDist hf-select" data-live-search="true" name="dist" data-validation="[NOTEMPTY]">
                @foreach($districts as $dist)
                <option value="{{ $dist->code }}">{{ $dist->name }}</option>
                @endforeach
              </select>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 0">
                <select class="form-control selectpicker ddCity hf-select" data-live-search="true" name="city" data-validation="[NOTEMPTY]">
                @foreach($cities as $city)
                <option value="{{ $city->code }}">{{ $city->name }}</option>
                @endforeach
              </select>
              </div>
            </div>
          </div>
        </div>
<!--         <div class="address-history"> -->
<!--           <div class="item"> -->
<!--             <div class="icon"> -->
<!--               <i class="material-icons">&#xE422;</i> -->
<!--             </div> -->
<!--             <div class="right-content"> -->
<!--               <div>68 Bạch Đằng</div> -->
<!--               <div>Phường 24, Bình Thạnh, Hồ Chí Minh</div> -->
<!--             </div> -->
<!--           </div> -->
<!--           <div class="item"> -->
<!--             <div class="icon"> -->
<!--               <i class="material-icons">&#xE422;</i> -->
<!--             </div> -->
<!--             <div class="right-content"> -->
<!--               <div>68 Bạch Đằng</div> -->
<!--               <div>Phường 24, Bình Thạnh, Hồ Chí Minh</div> -->
<!--             </div> -->
<!--           </div> -->
<!--         </div> -->
        <div class="time">
          Vào lúc
        </div>
        <div class="btn-group time-wrapper" data-toggle="buttons">
          <label class="btn time-rad">
                  <input type="radio" name="timeState" value="0"
                      data-validation="[NOTEMPTY]"
                      data-validation-group="lbTime"
                      data-validation-message="Chưa chọn thời gian">
                  <span class="icon icmn-radio-unchecked"></span>
                      Càng sớm càng tốt
              </label>
          <label class="btn time-rad">
                  <input type="radio" name="timeState" value="1"
                      data-validation-group="lbTime">
                  <span class="icon icmn-radio-unchecked"></span>
                      Ấn định thời gian
              </label>
        </div>
        <div id="excuteDatetime" class="row excute-date-wrapper" style="display: none">
              <div class="col-md-8 col-sm-8 col-xs-8" style="padding-left: 0; padding-right: 0">
                <select class="form-control selectpicker hf-select hf-select-date" data-live-search="false" name="estDate">
                @foreach($dates as $date)
                <option value="{{ $date }}">{{ $date }}</option>
                @endforeach
              </select>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-4" style="padding-right: 0">
                <select class="form-control selectpicker hf-select hf-select-time" data-live-search="false" name="estTime">
                @foreach($times as $time)
                <option value="{{ $time }}">{{ $time }}</option>
                @endforeach
              </select>
              </div>
        </div>
      </div>
      <div class="row-complete clearfix">
        <button id="btnBack" type="button" class="btn"><i class="material-icons">&#xE314;</i></button>
        <button id="btnSubmit" type="submit" class="btn btn-primary"><i class="material-icons">&#xE876;</i></button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      </div>
    </div>
  </form>
</section>
@endsection
