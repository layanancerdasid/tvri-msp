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
<script>
function edit_as_radio(o)
	{
			setTimeout(function(){
					jQuery(o).hide();
					jQuery(o).parent().append('<input title="Ditolak" type="radio" name="rd_jenis" value="Ditolak" onclick="jQuery(\'#hasil\').val(\'Ditolak\');"/> Ditolak <input title="Diterima" type="radio" name="rd_jenis" value="Diterima" onclick="jQuery(\'#hasil\').val(\'Diterima\');"/> Diterima');
					var xx = jQuery("#hasil").val();
					// console.info(xx);
					$('input[name=rd_jenis][value='+xx+']').attr('checked', true);
					
			},100);
	}
	
// open dialog for editing  
var opts = {  
    'ondblClickRow': function (id) {  
        jQuery(this).jqGrid('editGridRow', id, <?php echo json_encode_jsfunc($g->options["edit_options"])?>);  
    }  
};

function validate_onfocus(o) 
{ 
		if(jQuery('#volume').length>0) $('#volume').number( true, 2 );
}

function disableIfMobile(id){
	var grid = $('#list1');
	var rowid = grid.getGridParam('selrow');
	if (rowid)
	{
			var data = grid.getRowData(rowid);
			// alert(data.idpengembalian);
			if (data.platform.toLowerCase()=='mobile') // show only edit, no delete
			{
				$("#pg_list1_pager #add_list1, #list1_toppager #add_list1").addClass("ui-state-disabled");
				$("#pg_list1_pager #edit_list1, #list1_toppager #edit_list1").addClass("ui-state-disabled");
				$("#pg_list1_pager #del_list1, #list1_toppager #del_list1").addClass("ui-state-disabled");
			}else{
				$("#pg_list1_pager #add_list1, #list1_toppager #add_list1").removeClass("ui-state-disabled");
				$("#pg_list1_pager #edit_list1, #list1_toppager #edit_list1").removeClass("ui-state-disabled");
				$("#pg_list1_pager #del_list1, #list1_toppager #del_list1").removeClass("ui-state-disabled");
			}
	}
}

function validate_npwp(o) 
{ 
	if(jQuery('#npwp').length>0) $("#npwp").mask("99.999.999.9-999.999");
}

function unapproval(o,k) 
{ 
	swal({
			title: 'Unapprove Actifity?',
			text: ""+k,
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then(function () { 
				NProgress.start();
				$.ajax({
					url: '<?php echo base_url()?>approval/commitUnapprove/',
					type: "GET"
					,timeout: 100000
					,dataType: "json"
					,data: {"id": o}
					,xhr: function(){
						var xhr = $.ajaxSettings.xhr();
						 xhr.upload.onprogress = function(e) {
								// console.info(Math.floor(e.loaded / e.total *100) + '%');
								NProgress.inc();
						};
						return xhr;
					}	
				}).success(function(data){
						NProgress.done();
						if(data.result){
							swal('','Succes','success');
						}else{
							swal('','Unapproval error. With '+data.message,'error');
						}
				}).error(function(ex){
					swal('Oops!!','Error system: '+ex.toString(),'error');
					$('#load-button').prop('disabled', false);
					NProgress.done();
				}).done(function(finish){
					NProgress.done();
					$("#list1").trigger("reloadGrid");
				});
		})
}

function unallow(o,k) 
{ 
	swal({
			title: 'Unallow Actifity?',
			text: ""+k,
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then(function () { 
				NProgress.start();
				$.ajax({
					url: '<?php echo base_url()?>approval/commitUnallow/',
					type: "GET"
					,timeout: 100000
					,dataType: "json"
					,data: {"id": o}
					,xhr: function(){
						var xhr = $.ajaxSettings.xhr();
						 xhr.upload.onprogress = function(e) {
								// console.info(Math.floor(e.loaded / e.total *100) + '%');
								NProgress.inc();
						};
						return xhr;
					}	
				}).success(function(data){
						NProgress.done();
						if(data.result){
							swal('','Succes','success');
						}else{
							swal('','Unapproval error. With '+data.message,'error');
						}
				}).error(function(ex){
					swal('Oops!!','Error system: '+ex.toString(),'error');
					$('#load-button').prop('disabled', false);
					NProgress.done();
				}).done(function(finish){
					NProgress.done();
					$("#list1").trigger("reloadGrid");
				});
		})
}

// js event before save
jQuery.extend(jQuery.jgrid.inlineEdit, {
		restoreAfterError: false, // used to keep edit mode after input error
		beforeSaveRow: function (o,rowid) {
				// alert('before save inline event');
				return true;
		}
}); 

</script>
		
		<div class="animated fadeIn">
			<div class="row">
				<?php echo $breadcrumbs;?>
				<div id="infoMessage" class="form-group col-sm-12"><?php echo $message;?></div>
					<div class="breadcrumbs" style="margin-top: 0px;">
						<div class="col-sm-12">
							<div class="card" style="margin-top: 20px;border-color:transparent;padding-left: 2px;">
								<div  id="pangrid" style="padding-right:0.2em;" >
									<?php echo $gridout?>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
<script>
function validate_lat(o)
{ 
	ceklatlong();
}
function validate_long(o)
{ 
	ceklatlong();
}
	 
function ceklatlong()
{
	jQuery('#alamat').val('.'); 
	var lat = jQuery('#latitude').val();
	var lon = jQuery('#longitude').val(); 
	if((lat.length>3)&&(lon.length>3)){
		// console.info(lat.length, lon.length);
		jQuery('#alamat').val('Loading...');
		jQuery.ajax({
				url: '<?php echo base_url()?>survei/geocoding?latlng='+lat+','+lon,
				dataType: 'JSON',
				type: 'GET',
				error: function(res, status) {
					jQuery('#alamat').val(''); 
				},
				success: function( data ) {
					if(data.results>0){
						jQuery('#alamat').val(data.formatted_addres); 
						/*
						*/
						if(data.components.desa>0)
						setTimeout(function(){
							jQuery('#iddesa').val(data.components.desa).change(); 
						}, 1600);
						if(data.components.kec>0)
						setTimeout(function(){
							jQuery('#idkec').val(data.components.kec).change(); 
						}, 300);
						if(data.components.kabkot>0)
						setTimeout(function(){
							jQuery('#idkabupaten').val(data.components.kabkot).change(); 
						}, 900);
						if(data.components.prop>0)
						setTimeout(function(){
							jQuery('#idprovinsi').val(data.components.prop).change(); 
						}, 1200);
						// console.info(data.components); 
					}
				}
		});
	}
	
}

</script>