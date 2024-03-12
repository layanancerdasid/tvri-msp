<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/base/jquery-ui.custom.css"></link>  
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
</style>


		
		<div class="animated fadeIn">
			<div class="row">
				<?php echo $breadcrumbs;?>
				<div id="infoMessage"><?php echo $message;?></div>
					<div class="breadcrumbs" style="margin-top: 0px;">
						<div class="col-sm-12">
							<a href="auth/create_user" id="tambah" name="tambah" class="btn btn-secondary" style="margin-top: 10px;margin-left: 3px;border-radius: 5px;">Tambah User</a>
							<div class="card" style="margin-top: 10px;border-color:transparent;padding-left: 2px;">
								<div  id="pangrid" style="padding-right:0.2em;" >
									<?php echo $gridout?>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>