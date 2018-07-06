<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hand Free</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"/>
	
	<style>
		body {
			font-family: "Roboto", Tahoma, Sans-Serif;
		}
		.wrapper {
			background: #f5f5f5;
			min-height: 600px;
			color: #000;
		}
	</style>
</head>
<body>
	<div class="wrapper">
		<!-- Start Letter -->
		<div width="100%" style="background: #eceff4; padding: 50px 20px; color: #000;">
			<div style="max-width: 700px; margin: 0px auto; font-size: 14px">
				<div style="vertical-align: top; height: 85px; background-image: url('https://cdn.handfree.co/img/mail/header.png'); background-size: cover;"></div>
				<div style="padding: 40px 40px 20px 40px; background: #fff;">
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tr>
							<td>
								<h2 style="margin-bottom: 0px; color: #02b3e4; font-weight: 600">Cám ơn bạn đã sử dụng dịch vụ!</h2>
								<p>
									<span style="color: #a09bb9">Ngày {{ Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
								</p>
								<br />
								<h3 style="margin-bottom: 20px; color: #24222f; font-weight: 600">Đơn hàng {{ '#'.$order->no }}</h3>
								<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
									<tr>
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 3px solid #514d6a;">
											{{ $order->service->name }}
										</td>
										<td style="width: 10%; text-align: center; padding: 10px 10px; border-top: 3px solid #514d6a;">
											1
										</td>
										<td style="width: 20%; text-align: right; padding: 10px 0px 10px 10px; white-space: nowrap; border-top: 3px solid #514d6a;">
											{{ number_format($order->total_price,0,',','.') }}
										</td>
									</tr>
									<tr style="color: #aaa;">
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 1px solid #d9d7e0;">
											Tổng tiền
										</td>
										<td style="width: 10%; text-align: center; padding: 10px 10px; border-top: 1px solid #d9d7e0;">
											
										</td>
										<td style="width: 20%; text-align: right; padding: 10px 0px 10px 10px; white-space: nowrap; border-top: 1px solid #d9d7e0;">
											{{ number_format($order->total_price,0,',','.') }}
										</td>
									</tr>
									<tr style="color: #aaa;">
										<td style="text-align: left; padding: 0px 10px 10px 0px; border-top: 0px solid #d9d7e0;">
											Khuyến mãi
										</td>
										<td style="width: 10%; text-align: center; padding: 0px 10px; border-top: 0px solid #d9d7e0;">
											
										</td>
										<td style="width: 20%; text-align: right; padding: 0px 0px 10px 10px; white-space: nowrap; border-top: 0px solid #d9d7e0;">
											-
										</td>
									</tr>
									<tr>
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 3px solid #514d6a;">
											<span style="font-size: 18px; font-weight: bold; color: #02b3e4"">Thanh toán</span>
										</td>
										<td style="width: 10%; text-align: center; padding: 10px 10px; border-top: 3px solid #514d6a;">
											
										</td>
										<td style="width: 20%; text-align: right; padding: 10px 0px 10px 10px; white-space: nowrap; border-top: 3px solid #514d6a;">
											<span style="font-size: 18px; font-weight: bold; color: #02b3e4">VNĐ {{ number_format($order->total_price,0,',','.') }}</span>
										</td>
									</tr>
								</table>
								<br/>
								<br/>
								<h3 style="margin-bottom: 20px; color: #24222f; font-weight: 600">Chi tiết</h3>
								<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
									<tr>
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 1px solid #d9d7e0; white-space: nowrap; vertical-align: top">
											Khách hàng
										</td>
										<td style="width: 50%;padding: 10px 0px 10px 10px; border-top: 1px solid #d9d7e0;">
											<b>{{ $order->user->name }}</b>
											<br />
											{{ $order->user->phone }}
										</td>
									</tr>
									<tr>
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 1px solid #d9d7e0; white-space: nowrap; vertical-align: top">
											Đối tác thực hiện
										</td>
										<td style="width: 50%;padding: 10px 0px 10px 10px; border-top: 1px solid #d9d7e0;">
											<b>{{ $order->pro->name }}</b>
											<br />
											{{ $order->pro->phone }}
										</td>
									</tr>
									<tr>
										<td style="text-align: left; padding: 10px 10px 10px 0px; border-top: 1px solid #d9d7e0; white-space: nowrap; vertical-align: top">
											Vị trí & thời gian
										</td>
										<td style="width: 50%;padding: 10px 0px 10px 10px; border-top: 1px solid #d9d7e0;">
											<b>{{ $order->est_excute_at_string }}</b>
											<br />
											{{ $order->address }}
										</td>
									</tr>
								</table>
								<br />
								<br />
								<p style="text-align: center">Nếu bạn có vấn đề, hãy gọi đến <b style="color: #02b3e4">Bộ phận CSKH - 024 7304 1114</b> để được hỗ trợ.</p>
							</td>
						</tr>
					</table>
				</div>
				<div style="text-align: center; font-size: 12px; color: #a09bb9; margin-top: 20px">
					<p>
						Công ty Cổ phần Hand Free
						<br />
						99/1B Võ Văn Tần, Phường 6, Quận 3, Tp.HCM
						<br />
						<a href="https://handfree.co" style="text-decoration: none;">Web</a>
								<span>|</span>
								<a href="https://facebook.com/handfreeco" style="text-decoration: none;">Facebook</a>
						<br />
					</p>
				</div>
			</div>
		</div>
		<!-- End Start Letter -->
	</div>
</body>
</html>