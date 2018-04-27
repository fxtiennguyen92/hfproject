<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Hand Free</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0;">
 	<table cellpadding="0" cellspacing="0" width="100%">
  		<tr>
			<td bgcolor="#F2F2F2">
 				<table align="center" cellpadding="0" cellspacing="0" width="600">
 					<tr>
						<td bgcolor="transparent" align="center">
							<a href="https://handfree.co"><img src="https://handfree.co/img/logoh.png" alt="Hand Free Company" width="360" height="60" style="display: block; margin-top: 30px; margin-bottom: 30px;" /></a>
						</td>
					</tr>
					<tr>
						<td bgcolor="#FFF" style="box-shadow: 5px 5px 25px 0px rgba(46,61,73,0.2); padding-top: 20px; padding-bottom: 20px; padding-left: 30px; padding-right: 30px;">
							<p style="font-weight: 500;">Xin Chào {{ $name }},</p>
							<p>Để hoàn tất đăng ký, hãy xác nhận email của bạn: </p>
							<div style="text-align: center;  margin-top: 50px; margin-bottom: 20px;">
								<a href="{{ URL::to('partner/verify/' . $confirm_code) }}" style="text-align: center;background-color: #02B3E4; padding-top: 10px;padding-bottom: 10px;padding-left: 20px;padding-right: 20px; border-radius: 5px; color: #fff; text-decoration: none; letter-spacing: 2px">XÁC NHẬN EMAIL</a>
							</div>
							<p>Thân,</p>
							<p style="font-weight: 500">Hand Free Team</p>
						</td>
					</tr>
					<tr>
						<td bgcolor="transparent" align="center">
							<br>
							<div>
								<a href="https://handfree.co" style="text-decoration: none;">Web</a>
								<span>|</span>
								<a href="https://facebook.com/handfreeco" style="text-decoration: none;">Facebook</a>
							</div>
							<hr>
							<p>4/2 Đinh Bộ Lĩnh, Bình Thạnh, TPHCM</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>