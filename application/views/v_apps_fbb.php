<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Direktorat Pengembangan Pitalebar - <?php echo $heading;?></title>
    <meta name="description" content="Merupakan aplikasi pendukung yang wajib dimiliki oleh penerima bantuan program Layanan Internet Kabel Gratis (Fixed Broadband) dari Direktorat Infrastruktur Pita Lebar Kementerian Komunikasi dan Informatika untuk melaporkan mulainya dan permasalahan Layanan Internet Kabel Gratis.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url();?>images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <style>
		
		.loginbody{
			// background-color:#e9ebee !important;color:#212529; 
			background-image:url(../images/bg-login.jpg);
			
			background-color: rgba(210,255,82,1);
			background: @include filter-gradient(#d2ff52, #91e842, horizontal);
			background: @include background-image(radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(145,232,66,1) 100%));

			// background-position:center center; background-repeat:no-repeat; background-size:cover;
			}
			.footer{color:#212529;background-color:transparent;border-top:none;left:0;}
			.form-control {border-color: #CCCCCC;}
			.form-control, .btn {border-radius: 2px;}
			
			.login-form {max-width: 700px;margin: 0 auto;padding: 20% 0 0 0;left:0;}
			@media only screen and (min-width: 490px) {
				.login-form {padding: 9% 0 0 0;}
			}			
			.login-form form {
				color: #7a7a7a;
				border-radius: 0% 0;
				margin-bottom: 15px;
				font-size: 14px;
				box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
				padding: 10px;
				position: relative;
				min-height: 480px;

			}
			.login-form h2 {font-size: 18px;margin: 35px -2px 25px;}
			.login-form .avatar {position: absolute;margin: 0 auto;left: 0;right: 0;top: -70px;width: 95px;height: 95px;border-radius: 50%;				z-index: 9;background: #FFFFFF;padding: 15px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);background-image:url(../images/navs/kominfo_basic.png);				background-position:center;background-repeat:no-repeat;background-size:90%;}
			.login-form .avatar img {width: 100%;}	
			.login-form input[type="checkbox"] {margin-top: 2px;}
			.login-form a {color: #212529;text-decoration: underline;font-weight:bold;}
			.login-form a:hover {text-decoration: none;}
			.login-form form a {color: #7a7a7a;text-decoration: none;}
			.login-form form a:hover {text-decoration: underline;}			
			.btn-primary{background-image:url(../assets/img/menu-active2.png);}
			
    </style>
    

</head>
<body class="loginbody">
<div class="login-form">	
		<form>
			<div class="avatar"></div>
			<div class="col-sm-12">
					<div class="col-sm-6 pull-left"  style="background: rgba(255,255,255,0.8);padding:10px;max-height:450px;">
							<h5 class="text-sm-center mt-2 mb-1">FBB Mobile Apps</h5>
							<br>
							<p align='justify'>Merupakan aplikasi pendukung yang wajib dimiliki oleh penerima bantuan program Layanan Internet Kabel Gratis (Fixed Broadband) dari Direktorat Infrastruktur Pita Lebar Kementerian Komunikasi dan Informatika untuk melaporkan mulainya dan permasalahan Layanan Internet Kabel Gratis.</p>
							<hr>
							<p class="text-left small"><b>Requirement Spec: </b>
							<br>* Android Version 4.1 (Jelly Bean)
							<br>* Minimum 7MB
							<br>* Permission Internet
							</p>
							
							<p class="text-left small"><b>Petunjuk Penggunaan: </b>
							<br> <a href="<?php echo base_url()?>apps/fbbkonten/1" style="font-weight:normal;"><i class="fa fa-suitcase pr-1"></i>&nbsp;Cara Instalasi Aplikasi FBB Mobile Apps</a>
							<br> <a href="<?php echo base_url()?>apps/fbbkonten/2" style="font-weight:normal;"><i class="fa fa-ticket pr-1"></i>&nbsp;Cara Lapor Mulainya Layanan Akses Internet</a>
							<br> <a href="<?php echo base_url()?>apps/fbbkonten/3" style="font-weight:normal;"><i class="fa fa-thumbs-down pr-1"></i>&nbsp;Cara Lapor Gangguan/Mati Akses Internet</a>
							<br> <a href="<?php echo base_url()?>apps/fbbkonten/4" style="font-weight:normal;"><i class="fa fa-thumbs-up pr-1"></i>&nbsp;Cara Lapor Internet Sudah Nyala Kembali Setelah Gangguan</a>
							</p>
							
							
							
					</div>
					<div class="col-sm-6 pull-right"   style="background: rgba(255,255,255,0.8);padding:10px;max-height:450px;">
						<div class="">
						<h6 class="text-sm-center mt-2 mb-1" style="text-align:center;"><a href="www.android.com"><i class="fa fa-android">&nbsp;Android</i></a></h6>
							<h6 class="text-sm-center mt-2 mb-1" style="text-align:center;"><?php echo $message.' '.$version;?></h6>
							<div class="mx-auto d-block">
									<img class="mx-auto d-block" src='.././assets/img/fbb/qr_fbb_ippl.png' alt="Card image cap" style="width:80%">
							</div>
								<div class="location text-sm-center" style="text-align:center"> 
									<p class="text-center small">
										<h6><a href="<?php echo $link; ?>">Click here</a> for alternatif link to download apps.</h6>
									</p>
								</div>
						</div>
					</div>
												
			</div>
		</form>
</div>
						            
<script>
	setTimeout(function () {
			if ($("#infoMessage").text() !== '')  {
					$("#infoMessage").html('');
			}
	}, 5000);
</script>
    <script src="<?php echo base_url();?>assets/js/vendor/jquery-2.1.4.min.js"></script>
</body>
</html>

