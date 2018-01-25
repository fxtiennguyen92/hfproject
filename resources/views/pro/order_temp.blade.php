@extends('template.index')

@push('stylesheets')
	<link rel="stylesheet" type="text/css" href="css/baogia.css">
@endpush

@section('title')

@endsection

@section('content')
<section class="page-content">
	<div class="baogia col-sx-12"  style="padding-top:100px;">
	<div class="ttcn row">
    	<label  style=""> - <span style="padding:10%;">150.000 đ</span> +</label>
    	<div class="row col-sx-12" style="">
    		<div>
            	<img width="50" src="E:/handfree/icon/img/logo1.png" style="">
                <label style="">Vân phong</label>
                <div class="">
                	<div class="yeucau">sửa đường ống nước tại nhà riêng.tinh trạng hỏng:ống nước bị bể</div>
                    <div class="diachi"><span class=" icon icmn-location"></span>69 Điện Biên Phủ,Đa Kao,Q1 </div>
                    <div class="thoigian" ><span class="icon icmn-clock"></span>Ngay lập tức</div>
                </div>
            </div>
    	</div>
        
    </div>
	<div class=" gui col-sx-12"> 
    	<button type="button" class="btn btn-primary margin-inline">Gửi báo giá</button>
    </div>
</div>
</section>
@endsection