<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

<style>
.ui-jqgrid tr.jqgrow td 
{
	vertical-align: top;
	white-space: normal !important;
	padding:2px 5px;
}

.ui-jqgrid tr.jqgrow td 
{
	vertical-align: top;
	white-space: normal !important;
	padding:2px 5px;
}

/* change color of group text */ 
.jqgroup b { 
	color: navy; 
} 
 
.ui-jqgrid tr.jqgroup td 
{ 
	vertical-align: top;
	background-color: lightyellow; 
	padding-left: 10px
} 

.ui-jqgrid tr.footrow td 
{ 
	background-color: whitesmoke; 
}

.ui-icon .ui-icon-radio-off .tree-leaf .treeclick
{ 
	background-color: red; 
}

	
</style>

<script src="<?php echo  base_url() ?>assets/js/vendor/jquery.number.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/js/vendor/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/js/custom_gridphpgrid.js" type="text/javascript"></script>

	
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-1">
				<!--begin::Page Heading-->
				<?=$breadcrumbs;?>
				<!--end::Page Heading-->
			</div>
			<!--end::Info-->
			
		</div>
	</div>
	<!--end::Subheader-->
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container-fluid">
			<input type="hidden" id="keytransmisi" name="keytransmisi" disabled="disabled">
			<input type="hidden" id="labtransmisi" name="labtransmisi" disabled="disabled">
			<div class="card col-lg-12">
				<ul class="nav nav-pills" id="Tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="lokasi-tab1" data-toggle="tab" href="#lokasi-1">
							<span class="nav-icon">
								<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Lokasi</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="pemancar-tab-2" data-toggle="tab" href="#pemancar-2" aria-controls="pemancar">
							<span class="nav-icon">
								<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Pemancar</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="tower-tab-3" data-toggle="tab" href="#tower-3" aria-controls="tower">
							<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Tower</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="sistemantena-tab-4" data-toggle="tab" href="#sistemantena-4" aria-controls="sistemantena">
							<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Sistem Antena</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="catudaya-tab-5" data-toggle="tab" href="#catudaya-5" aria-controls="catudaya">
							<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Catu Daya</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="ups-tab-6" data-toggle="tab" href="#ups-6" aria-controls="ups">
							<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">UPS</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="parabola-tab-7" data-toggle="tab" href="#parabola-7" aria-controls="parabola">
							<span class="nav-icon">
									<i class="flaticon2-layers-1"></i>
							</span>
							<span class="nav-text">Parabola</span>
						</a>
					</li>							
				</ul>
				<div class="tab-content mt-5" id="myTabContent1">	
					<div class="tab-pane fade show active col-lg-12" id="lokasi-1" role="tabpanel" aria-labelledby="lokasi-tab-1">
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b">
									<?=$gridlokasi;?>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="pemancar-2" role="tabpanel" aria-labelledby="pemancar-tab-2">
						<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">Peralatan Pemancar</h4>
							<p>Terdiri dari informasi mendasar mengenai pemancar dan peralatan apa saja yang diperlukan dalam memancarkan gelombang.</p>
							<div class="border-bottom border-white opacity-20 mb-5"></div>
							<p class="mb-0">Pemancar dibagi menjadi dua yaitu Analog dan Digital.</p>
						</div>
						<div class="row">	
							<div id="gridpemancar" class="card-body card-stretch gutter-b col-lg-12"></div>
						</div>
					</div>
					<div class="tab-pane fade" id="tower-3" role="tabpanel" aria-labelledby="tower-tab-3">
						<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">Tower</h4>
							<p>Terdiri dari informasi mendasar mengenai tower, bagaimana kondisi disik tower dan terkait informasi lainnya.</p>
						</div>
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b col-lg-12">
									<div id="gridtower"></div>
								</div>
							</div>
						</div>
					</div>										
					<div class="tab-pane fade" id="sistemantena-4" role="tabpanel" aria-labelledby="sistemantena-tab-4">
						<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">Sistem Antena</h4>
							<p>Terdiri dari informasi mendasar mengenai Antena seperti panel, gain, kondisi fisik antena, dan informasi terkait lainnya.</p>
						</div>
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b">
									<div id="gridsistemantena"></div>
								</div>
							</div>
						</div>
					</div>										
					<div class="tab-pane fade" id="catudaya-5" role="tabpanel" aria-labelledby="catudaya-tab-5">
						<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">Catu Daya</h4>
							<p>Meliputi informasi mengenai sumber listrik utama, baik dari jenisnya maupun besaran daya Kilo Volt Amphere (KVA) dari setiap sumbernya.</p>
						</div>
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b">
									<div id="gridcatudaya"></div>
								</div>
							</div>
						</div>
					</div>										
					<div class="tab-pane fade" id="ups-6" role="tabpanel" aria-labelledby="ups-tab-6">
						<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">UPS (Uninterruptable Power Supply)</h4>
							<p>Berapa banyak UPS yang dimiliki pemancar untuk mendukung sumber daya utama, terdiri dari merk, kapasitas, kondisi, dan tahun perolehan.</p>
						</div> 
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b">
									<div id="gridups"></div>
								</div>
							</div>
						</div>
					</div>										
					<div class="tab-pane fade" id="parabola-7" role="tabpanel" aria-labelledby="parabola-tab-7">
					<div class="alert alert-info mb-5 p-5" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="ki ki-close"></i></span>
							</button>
							<h4 class="alert-heading">Parabola</h4>
							<p>Terdiri dari beberapa komponen seperti merk, diameter, tipe, kondisi, dan tahun diperolehnya parabola tersebut.</p>
						</div> 
						<div class="row">
							<div class="card">
								<div class="card-body card-stretch gutter-b">
									<div id="gridparabola"></div>
								</div>
							</div>
						</div>
					</div>										
			</div>									
		</div>
		
		
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->

<script type="text/javascript">
$().ready(function () {	
	
	$('a[id^=pemancar-tab-2]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/pemancar/"+ idlokasi,
				async : true,
				success: function (result) {
						$("#gridpemancar").html(result).show();
				}
				
			});
		}
	});
	
	$('a[id^=tower-tab-3]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/tower/"+ idlokasi,
				async : true,
				contentType: "html",
				success: function (result) {
					$("#gridtower").html(result);
				}
				
			});
		}
	});
		
	$('a[id^=sistemantena-tab-4]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/sistemantena/"+ idlokasi,
				async : true,
				success: function (result) {
					$("#gridsistemantena").html(result).show();
				}
			});
		}
	});
	
	$('a[id^=catudaya-tab-5]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/catudaya/"+ idlokasi,
				async : true,
				success: function (result) {
					$("#gridcatudaya").html(result).show();
				}
			});
		}
	});
	
	$('a[id^=ups-tab-6]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/ups/"+ idlokasi,
				async : true,
				success: function (result) {
					$("#gridups").html(result).show();
				}
			});
		}
	});
	
	$('a[id^=parabola-tab-7]').click(function () {
		var idlokasi;
		idlokasi = $('#keytransmisi').val();
		$("#gridpemancar").html("<div class='spinner'></div>").show();
		if(idlokasi.length < 5){
			setTimeout(function(){ 
				$("#gridpemancar").html("<center>Mohon tentukan lokasi LPP TVRI dulu.</center>").show();
			}, 1500);
		}else{
			$.ajax({
				url: "<?=base_url()?>transmisi/parabola/"+ idlokasi,
				async : true,
				success: function (result) {
					$("#gridparabola").html(result).show();
				}
			});
		}
	});

});
</script>