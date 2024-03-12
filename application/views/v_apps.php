<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Direktorat Pengembangan Pitalebar - <?php echo $heading;?></title>
    <meta name="description" content="SIPEMPRO (Sistem Informasi Pemantauan Project) sebuah platform aplikasi yang bertujuan untuk melakukan pemantauan project ataupun survei secara realtime dan akurat.">
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
			
			.login-form {max-width: 650px;margin: 0 auto;padding: 22% 0 0 0;left:0;}
			@media only screen and (min-width: 490px) {
				.login-form {padding: 9% 0 0 0;}
			}			
			.login-form form {
				color: #7a7a7a;
				border-radius: 0% 0;
				margin-bottom: 15px;
				font-size: 14px;
				background: rgba(255,255,255,0.35);			
				box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
				padding: 30px;
				position: relative;
				min-height: 420px;

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
                        <div class="col-mb-3 pull-left" style="background: rgba(255,255,255,0.8);padding:10px;">	
													<h2 class="text-center">SIPEMPRO Mobile Apps</h2>  
													<p class="text-center small">
													<?php echo $message.' '.$version;?><br><a href="<?php echo $link; ?>">Click here</a> for alternatif link to download apps.</p><br>
													<p class="text-left small"><b>Requirement Spec: </b>
													<br>* Android Version 4.1 (Jelly Bean)
													<br>* Minimum 7MB
													<br>* Permission Internet, Camera, Storage
													</p>
													<br/><br/><br/><br/><br/><br/>
												</div>                        
                        <div class="col-mb-3 pull-right">	
													<img src='.././assets/img/qr_dppl.png'/>
                        </div>                        
								</form>
								</div>
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

