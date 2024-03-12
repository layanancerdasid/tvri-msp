<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <title>Direktorat Pengembangan Pitalebar - Meeting Attendance</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?=$heading;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta property="og:title" content="Direktorat Pengembangan Pitalebar - Meeting Attendance">
		<meta property="og:image" content="<?=base_url();?>images/favicon.ico">
		<meta property="og:description" content="<?=$heading;?>">
		<meta property="og:url" content="<?=$heading;?>">

    <link rel="shortcut icon" href="<?=base_url();?>images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?=base_url();?>images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="<?=base_url();?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/cs-skin-elastic.css">
		<link href="<?=base_url()?>assets/css/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="<?=base_url();?>assets/css/jquery.signaturepad.css" rel="stylesheet">
		<script src="<?=base_url();?>assets/js/vendor/jquery-2.1.4.min.js"></script>		
		<script src="<?=base_url();?>assets/js/numeric-1.2.6.min.js"></script> 
		<script src="<?=base_url();?>assets/js/bezier.js"></script>
		<script src="<?=base_url();?>assets/js/jquery.signaturepad.js"></script> 
		
		<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
		<script src="<?=base_url()?>assets/js/json2.min.js"></script>
		<script src="<?=base_url()?>assets/js/sweetalert2.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <style>
		
		.loginbody{
			background-image:url(../images/bg-login.jpg);
			background-color: rgba(210,255,82,1);
			background: @include filter-gradient(#d2ff52, #91e842, horizontal);
			background: @include background-image(radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(145,232,66,1) 100%));
		}
		.footer{color:#212529;background-color:transparent;border-top:none;left:0;}
		.form-control {border-color: #CCCCCC;}
		.form-control, .btn {border-radius: 2px;}
			
		.login-form {max-width: 900px;margin: 0 auto;padding: 20% 0 0 0;left:0;}
		@media only screen and (min-width: 400px) {
			.login-form {padding: 9% 0 0 0;}
		}			
		
		
		@media screen and (max-width: 992px) {
			
		}

		/* On screens that are 600px wide or less, make the columns stack on top of each other instead of next to each other */
		@media screen and (max-width: 600px) {
			.row {
				flex-direction: column;
			}
			
			.col-6 {
				width: 200%;
				background-color: lightblue;
			}
			[class*="col-"] {
				width: 100%;
			}
			.loginbody{
				background-color: rgba(210,255,82,1);
				background: @include filter-gradient(#d2ff52, #91e842, horizontal);
				background: @include background-image(radial-gradient(center, ellipse cover, rgba(210,255,82,1) 0%, rgba(145,232,66,1) 100%));
			}
			input {
				
			}
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
			.login-form .avatar {position: absolute;margin: 100 auto;left: 0;right: 0;top: -70px;width: 95px;height: 95px;border-radius: 50%;				z-index: 9;background: #FFFFFF;padding: 15px;box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);background-image:url(../images/navs/kominfo_basic.png);				background-position:center;background-repeat:no-repeat;background-size:90%;}
			.login-form .avatar img {width: 100%;}	
			.login-form input[type="checkbox"] {margin-top: 2px;}
			.login-form a {color: #212529;text-decoration: underline;font-weight:bold;}
			.login-form a:hover {text-decoration: none;}
			
			#signArea{
				width:304px;
				margin: 0px auto;
			}
			.sign-container {
				width: 60%;
				margin: auto;
			}
			.sign-preview {
				width: 150px;
				height: 50px;
				border: solid 1px #CFCFCF;
				margin: 10px 5px;
			}
			.tag-ingo {
				font-family: cursive;
				font-size: 12px;
				text-align: left;
				font-style: oblique;
			}
			
    </style>
    

</head>
<body class="loginbody">
<div class="login-form">	
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
									<div class="card-title" style="background-color:#1474ae">
													<a class="navbar-brand" href="#"><img src="<?=base_url();?>assets/img/logosmalkominfo.png" alt="Logo"></a>
												</div>
							<div class="card-body">
								<!-- Credit Card -->
								<div id="bodinput">
										<div class="card-body">
														<div class="form-group text-center">
																<strong class="card-title">Daftar Hadir Kegiatan</strong>
														</div>
												<hr>
												
														<div class="form-group text-center">
																Direktorat Pengembangan Pitalebar
														</div>
														
														<div class="row">
															<div class="col-md-12">
																<a id="btnshare" class="btn btn-sm btn btn-primary pull-right" style="border: 0;padding: 5px;
    border-radius: 3px;background-image: linear-gradient(135deg, #fdeb71 10%, #f8d800 100%);cursor: pointer;color: #04048c;font-size: 16px;position: relative;top: 0;transition: all 0.2s ease;
    ">
																		<i class="fa fa-share-alt" aria-hidden="true">&nbsp;Share</i>
																</a>
															</div>
														</div>
														
														
														<div class="form-group">
																<label for="cc-agenda" class="control-label mb-1">Judul Rapat</label>
																<textarea name="nama_agenda" id="nama_agenda" disabled="" rows="2" placeholder="<?=$nama_agenda;?>" class="form-control"></textarea>
														</div>
														
														
														
														<div class="row">
																<div class="col-md-6">
																		<div class="form-group">
																				<label for="cc-name" class="control-label mb-1">Nama <label class="text-danger">*</label></label>
																				<input id="idmom" name="idmom" type="hidden" value="<?=$idmom;?>">
																				<input id="nama" name="nama" type="text" class="form-control cc-name valid" placeholder="Nama Lengkap">
																		</div>
																</div>
																<div class="col-md-6">
																		<label for="cc-number" class="control-label mb-1">NIP <label class="text-danger">&nbsp;</label></label>
																		<input id="nip" name="nip" type="tel" class="form-control cc-number identified visa" placeholder="ex. 999999999">
																</div>
														</div>
														<div class="row">
																<div class="col-md-6">
																		<div class="form-group">
																				<label for="cc-exp" class="control-label mb-1">No Kontak <label class="text-danger">*</label></label>
																				<input id="telp" name="telp" type="tel" class="form-control cc-exp" placeholder="ex. +62 999 9999 999">
																		</div>
																</div>
																<div class="col-md-6">
																		<label for="x_card_code" class="control-label mb-1">Email <label class="text-danger">&nbsp;</label></label>
																		<div class="input-group">
																				<input id="email" name="email" class="form-control cc-cvc" placeholder="ex. djakarta@example.com">
																		</div>
																</div>
														</div>
														<div class="row">
																<div class="col-md-6">
																		<div class="form-group">
																				<label for="jabatan" class="control-label mb-1">Jabatan <label class="text-danger">*</label></label>
																				<input id="jabatan" name="jabatan" class="form-control cc-exp" placeholder="Fungsional/Struktural/...">
																		</div>
																</div>
																<div class="col-md-6">
																		<label for="instansi" class="control-label mb-1">Instansi <label class="text-danger">*</label></label>
																		<div class="input-group">
																				<input id="instansi" name="instansi" class="form-control cc-cvc" placeholder="Kementrian/Lembaga/...">
																		</div>
																</div>
														</div>
														<div class="form-group">
																<label for="cc-agenda" class="control-label mb-1">Jam & Tanggal<label class="text-danger">*</label></label>
																<div class="input-group">
																<input id="inp-timestamp" name="inp-timestamp" disabled=""  type="text" class="form-control cc-name valid" value="<?=Date('d M Y H:i:s')?>">
																</div>
														</div>
														
														<div class="form-group">
																<div id="signArea" >
																<h2 class="tag-ingo">Silakan tanda tangan dibawah ini,</h2>
																<div class="sig sigWrapper" style="height:auto;">
																	<div class="typed"></div>
																	<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
																</div>
																<span class="clearButton btn-warning btn-block text-center"><a href="#clear">Clear</a></span>
															</div>
															
														</div>
														
														
														
														<div>
																<button id="btnsubmitatt" type="submit" class="btn btn-lg btn-info btn-block">
																		<span id="btnsubmitatt-button-amount">Submit</span>
																</button>
																
														</div>
										</div>
								</div>

							</div>
					</div> <!-- .card -->

				</div><!--/.col-->
												
			</div>
</div>
						            
    
<script>
	$(document).ready(function() {
		// $('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90, clear : '.clearButton'});
		var options = {
				drawOnly: true,
				drawBezierCurves:true,
				lineTop:90,
				clear: '.clearButton',
				// defaultAction: 'drawIt',
				// validateFields: false,
				// lineWidth: 0,
				// output: null,
				// sigNav: null,
				// name: null,
				// typed: null,
				// typeIt: null,
				// drawIt: null,
				// typeItDesc: null,
				// drawItDesc: null,
				// penColour: '#000',
		};
		var api = $('#signArea').signaturePad(options);
		$('.clearButton').click(function(){
				var sig = api.getSignatureString();
				api.clearCanvas();
				// Regenerate the signature with the updated option
				// api.updateOptions({ penColour: '#00FF00' }).regenerate(sig);
		});
		
		
		$('#btnsubmitatt').click(function(e){
			 $(this).attr('disabled', true);
			 // validasi
			  $(this).attr('disabled', true);
				if ($("#nama").val() == "") {
					$("#nama").focus();
					swal('Oops!','nama wajib disi!','warning');
					$("#nama")[0].scrollIntoView();
					$(this).attr('disabled', false);
					return false;
				}
				if ($("#telp").val() == "") {
					$("#telp").focus();
					swal('Oops!','No kontak wajib disi!','warning');
					$("#telp")[0].scrollIntoView();
					$(this).attr('disabled', false);
					return false;
				}
				if ($("#jabatan").val() == "") {
					$("#jabatan").focus();
					swal('Oops!','Jabatan wajib disi!','warning');
					$("#jabatan")[0].scrollIntoView();
					$(this).attr('disabled', false);
					return false;
				}
				if ($("#instansi").val() == "") {
					$("#instansi").focus();
					swal('Oops!','Instansi wajib disi!','warning');
					$("#instansi")[0].scrollIntoView();
					$(this).attr('disabled', false);
					return false;
				}
			var img_data ;
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function (canvas) {
						var canvas_img_data = canvas.toDataURL('image/png');
						img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
						//ajax call to save image inside folder
						// console.info(img_data);
						$.ajax({
							url: '<?=base_url();?>mom/saveattendance',
							data: {idmom:$("#idmom").val()
											,nama:$("#nama").val()
											,nip:$("#nip").val()
											,telp:$("#telp").val()
											,email:$("#email").val()
											,jabatan:$("#jabatan").val()
											,instansi:$("#instansi").val()
											,paraf:img_data  
										},
							type: 'post',
							dataType: 'json',
							success: function (response) {
								if(response.status == 1){
									swal("","Terima Kasih, "+response.message,"success");
									// window.location.reload();
									$("#bodinput").html("<div class='card-body'>"+
																			"<div class='form-group text-center'><h2><strong class='card-title'>Terima Kasih</strong></h2>"+
																			"<div class='form-group text-center'>"+response.message+"</div>"+
																			"</div>"
																			);
								}else{
									swal("Opps","penyimpanan gagal","warning");
								}
									return false; 
							}
						});
						
					}
				});
				
				$(this).attr('disabled', false);
				
			});
			
			
	
	});
	
	$('#btnshare').on('click', function() {
		var $temp = $("<input>");
		var $url = $(location).attr('href');
		$("body").append($temp);
		$temp.val($url).select();
		document.execCommand("copy");
		$temp.remove();
		swal("","URL copied!","success");
	})
	
			
</script>
</body>
</html>

