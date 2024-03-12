<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-id.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

<script src="<?php echo  base_url() ?>assets/js/gridjs.production.min.js"></script>
<link href="<?php echo  base_url() ?>assets/css/mermaid.min.css" rel="stylesheet" />
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
										<a class="nav-link active" id="rab-tab1" data-toggle="tab" href="#kak" onClick="tabular">
											<span class="nav-icon">
												<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Kerangka Acuan Kerja (KAK)</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="rab-tab-2" data-toggle="tab" href="#rab" onClick="tabular" aria-controls="rab">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Rencana Anggaran Biaya (RAB)</span>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="spek-tab-3" data-toggle="tab" href="#spek" onClick="tabular" aria-controls="spek">
											<span class="nav-icon">
													<i class="flaticon2-layers-1"></i>
											</span>
											<span class="nav-text">Lampiran (Spesifikasi, dll)</span>
										</a>
									</li>					
								</ul>
									<div class="tab-content mt-5" id="myTabContent1">	
									<div class="tab-pane fade show active col-lg-12" id="kak" role="tabpanel" aria-labelledby="kak-tab-1">
										<div class="row">
											<div class="card">
													<div class="card-body card-stretch gutter-b">
														<?=$gridkak;?>
													</div>
												</div>
										</div>
									</div>
									
									<div class="tab-pane fade" id="rab" role="tabpanel" aria-labelledby="rab-tab-2">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridrab;?>
												</div>
											</div>
										</div>
									</div>										
									<div class="tab-pane fade" id="spek" role="tabpanel" aria-labelledby="spek-tab-4">
										<div class="row">
											<div class="card">
												<div class="card-body card-stretch gutter-b">
													<?=$gridspek;?>
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
