<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

<script src="https://unpkg.com/gridjs/dist/gridjs.production.min.js"></script>
<link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
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
	<!--begin::Card-->
								<div class="col-lg-12">
									<ul class="nav nav-pills" id="Tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="lokasi-tab1" data-toggle="tab" href="#lokasi-1" onClick="tabular">
											<span class="nav-icon">
												<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Lokasi</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pemancar-tab-2" data-toggle="tab" href="#pemancar-2" onClick="tabular" aria-controls="pemancar">
											<span class="nav-icon">
												<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Pemancar</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a class="nav-link" id="tower-tab-3" data-toggle="tab" href="#tower-3" onClick="tabular" aria-controls="tower">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Tower</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="sistemantena-tab-4" data-toggle="tab" href="#sistemantena-4" onClick="tabular" aria-controls="sistemantena">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Sistem Antena</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="catudaya-tab-5" data-toggle="tab" href="#catudaya-5" onClick="tabular" aria-controls="catudaya">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Catu Daya</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="ups-tab-6" data-toggle="tab" href="#ups-6" onClick="tabular" aria-controls="ups">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">UPS</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="parabola-tab-7" data-toggle="tab" href="#parabola-7" onClick="tabular" aria-controls="parabola">
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
										<div class="row">	
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridpemancar;?>
												</div>
											</div>
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$griddetailpemancar;?>
												</div>
											</div>
											
										</div>
									</div>
									
									<div class="tab-pane fade" id="tower-3" role="tabpanel" aria-labelledby="tower-tab-3">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridtower;?>
												</div>
											</div>
										</div>
									</div>										
									<div class="tab-pane fade" id="sistemantena-4" role="tabpanel" aria-labelledby="sistemantena-tab-4">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridsistemantena;?>
												</div>
											</div>
										</div>
									</div>										
									<div class="tab-pane fade" id="catudaya-5" role="tabpanel" aria-labelledby="catudaya-tab-5">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridcatudaya;?>
												</div>
											</div>
										</div>
									</div>										
									<div class="tab-pane fade" id="ups-6" role="tabpanel" aria-labelledby="ups-tab-6">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridups;?>
												</div>
											</div>
										</div>
									</div>										
									<div class="tab-pane fade" id="parabola-7" role="tabpanel" aria-labelledby="parabola-tab-7">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridparabola;?>
												</div>
											</div>
										</div>
									</div>										
								</div>									
							</div>
													
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
		<div class="container">
			<?=$gridout;?>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->
<script>

function() {
    $( "#Tabs" ).Tabs();
});

function tabular(link, div_id, gridlokasi, gridpemancar, gridsistemantena, gridcatudaya, gridups, gridparabola, griddetailpemancar)
{
   $.ajax(link, { data: { gridlokasi: gridlokasi, gridpemancar: gridpemancar, gridsistemantena: gridsistemantena,
   gridcatudaya: gridcatudaya, gridups: gridups, gridparabola:gridparabola },
   type: "post",
     success: function(data) {
       $('#'+div_id).fadeOut("medium", function(){
       $(this).append(data);
      $('#'+div_id).fadeIn("medium");
     });
  }
 });
}
</script>			
