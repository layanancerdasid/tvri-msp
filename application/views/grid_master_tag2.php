<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/select2.css">
<script src="<?php echo base_url();?>assets/js/select2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.fancybox.min.css" />
<script src="<?php echo base_url();?>assets/js/readmore.min.js" type="text/javascript"></script>

<!-- date -->
<link href="<?php echo  base_url() ?>assets/vendor/datetimepicker/css/daterangepicker.css" rel="stylesheet" /> 

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

#s2id_kepada
{ 
	width:100%;
	height:auto !important;
}


</style>

<script>
	function do_loadmore()
	{
		jQuery('.readmore').readmore({
			blockCSS: 'display:block;',
			moreLink: '<a class="white-shadow" href="#" style="color:red"><i>Read More</i></a>',
			evenMoreLink: '<a class="white-shadow" href="#">Even More informations</a>', // Add new label
			lessLink: '<a href="#" style="color:red"><i>Less information</i></a>',
			afterToggle: function(trigger, element, expanded) {
				if(! expanded) {
					$('html, body').animate( { scrollTop: element.offset().top }, {duration: 100 } );
				}
			} 
		});
	}
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



// js event before save
jQuery.extend(jQuery.jgrid.inlineEdit, {
		restoreAfterError: false, // used to keep edit mode after input error
		beforeSaveRow: function (o,rowid) {
				// alert('before save inline event');
				return true;
		}
}); 
</script>		
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
		<div class="container">
			<?=$gridout;?>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->	


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

function link_select2(id)
{
	var el = $('select[id='+id+'].FormElement')[0];
	if (el)
	{
		// remove nbsp; from start of textarea
		if(el.previousSibling) el.parentNode.removeChild(el.previousSibling);
		jQuery(el).parent().css('padding-left','5px');
		jQuery(el).parent().css('padding-bottom','5px');
	}

	$('select[name='+id+'].editable, select[id='+id+']').select2({width:'90%'});
	$(document).unbind('keypress').unbind('keydown');
}	

</script>

<script src="<?php echo  base_url() ?>assets/vendor/datetimepicker/js/moment.min.js"></script>
<script src="<?php echo  base_url() ?>assets/vendor/datetimepicker/js/daterangepicker.js"></script>
<script>
$(document).ready(function () {
	var start = moment();
	var end = moment();
	var m = moment();
	
	$('input[name="daterange"]').daterangepicker({
		startDate: start,
		endDate: end,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'This Month': [moment().startOf('month'), moment()],
		   'Last Mont': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		   'This Year': [moment().startOf('year'), moment()]
		},
		locale: {
		  format: 'DD/MM/YYYY'
		}
	});
	
	$('#daterange').change(function(){
		var vals = $(this).val();
		var arr_date = vals.split(" - ");
		
		var periode = "start="+arr_date[0]+"&end="+arr_date[1];
		window.location.href = "<?=$page;?>?" + periode;
		
	});
	
	var start = '<?php echo $date_start; ?>';
	if(start!==''){
		var a = '<?php list($dd, $mm, $yyyy) = explode('/',$date_start);echo $dd.'/'.$mm.'/'.$yyyy;?>';
		var b = '<?php list($dd, $mm, $yyyy) = explode('/',$date_end);echo $dd.'/'.$mm.'/'.$yyyy;?>';
		$('#daterange').val(a+' - '+b);
	}	
	

});
</script>