<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Direktorat Pengembangan Pitalebar - Bantuan Pengguna</title>
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
			background-image:url(../../images/bg-login.jpg);
			
			background-color: rgba(210,255,82,1);
			background: @include filter-gradient(#d2ff52, #91e842, horizontal);
			background: @include background-image(radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(145,232,66,1) 100%));

			// background-position:center center; background-repeat:no-repeat; background-size:cover;
			min-height: 100vh;
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
				padding: 10px;
				position: relative;

			}
			label {
				color:black;
			}
			.login-form h2 {font-size: 18px;margin: 35px -2px 25px;}
			.login-form .avatar {position: absolute;margin: 0 auto;left: 0;right: 0;top: -70px;width: 95px;height: 95px;border-radius: 50%;				z-index: 9;background: #FFFFFF;padding: 15px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);background-image:url(../../images/navs/kominfo_basic.png);				background-position:center;background-repeat:no-repeat;background-size:90%;}
			.login-form .avatar img {width: 100%;}	
			.login-form input[type="checkbox"] {margin-top: 2px;}
			.login-form a {color: #212529;text-decoration: underline;font-weight:bold;}
			.login-form a:hover {text-decoration: none;}
			.login-form form a {color: #7a7a7a;text-decoration: none;}
			.login-form form a:hover {text-decoration: underline;}			
			.btn-primary{background-image:url(../../assets/img/menu-active2.png);}
			
    </style>
    

</head>
<body class="loginbody">
<div class="login-form">	
	<div class="col-sm-12">
		<div class="col-sm-12 pull-left"  style="background: rgba(255,255,255,0.8);padding:10px;">
			<br>
			
			<div class="card-body card-block" style="padding-top:0px;">
				<div class="avatar"></div>
				<p><h4><strong>Formulir Bantuan Pengguna</strong></h4></p>
				<hr/>
				<!--<br/>Program Penerima Bantuan Internet Kabel Gratis Fixed Broadband (FBB)-->
				<div>
					<?php echo $alert; ?>
				</div>
				<p>Klik link berikut untuk kembali ke halaman <a href="https://ippl.ptmsp.id/apps/contactus">Formulir Bantuan</a></p>
				<!--<form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8"><br/>*pola nomor telepon = 08xxxxxxxxxx
				<form action="https://ippl.ptmsp.id/apps/get_contact" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
					<div class="form-group">
						<label for="nf-telp" class=" form-control-label" style="color:black;">Telepon</label>
						<input type="tel" id="phone" name="phone" placeholder="Masukkan nomor telepon, misal 08xxxxxxxxxx" class="form-control" pattern="[0-9]{12}|[0-9]{11}" required>
					</div>
					<div class="form-group">
						<label for="nf-email" class=" form-control-label">Email</label>
						<input type="email" id="email" name="email" placeholder="Masukkan email" class="form-control">
					</div>
					<div class="form-group">
						<label for="nf-desc" class=" form-control-label">Deskripsi</label>
						<textarea name="desc" id="desc" rows="4" placeholder="Masukkan keterangan" class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label for="nf-foto" class=" form-control-label">Lampirkan foto atau screenshot aplikasi, maksimal 2 MB</label>
						<input type="file" name="berkas" id="berkas" />
					</div>
					<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block">
						Kirim
					</button> 
				</form>-->
			</div>
		</div>		
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
<script>
	
	//when submit clicked, button disable
	$("#submit").click( function() {
		// var fotoSize = $('#berkas').files[0].size;
		// console.info($('#berkas').files[0].size);return false;
		
		// if (($("#berkas"))[0].files.length < 2) {
			
		if (($("#berkas"))[0].files.length > 2097152) {
			alert("Ukuran Foto yang anda masukkan terlalu besar. Lampirkan Foto berukuran maksimal 1 MB");
			return false;
		}
		
		if($("#phone").val().length === 0) {
			alert("Kolom Telepon tidak boleh kosong");
			return false;
		} 
		
		if($("#desc").val().length === 0) {
			alert("Kolom Deskripsi tidak boleh kosong");
			return false;
		}
		
		// return false;
		$(this).attr("disabled", true); 
		
	});
	
	// $('form').submit(function(e) {
        // e.preventDefault();
		
		// $.ajax({
			// url:'<?php echo base_url()?>apps/get_contact?',
			// type:"post",
			// data:new FormData(this),
			// processData:false,
			// contentType:false,
			// cache:false,
			// async:false,
			// success: function(result){
				// var data = jQuery.parseJSON(result);
				// // console.info(data);
				// // console.info(data.msg);
				// // return false ;
				// // alert("Upload Image Successful.");
				
				// $('#alert').empty();
				// // if(data.status == 0) {
					// // $("#submit").attr("disabled", false);
				// // }
				// $('#alert').html(data.msg);
			// }
		// });

    // });
</script>
</body>
</html>

