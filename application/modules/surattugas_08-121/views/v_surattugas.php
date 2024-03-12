<script src="<?php echo  base_url() ?>assets/js/custom_gridphpgrid.js" type="text/javascript"></script>
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

<!-- buat bikin combo multi -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/select2/3.5.2/select2.css">
<script src="//cdn.jsdelivr.net/select2/3.5.2/select2.min.js"></script>
<script>	
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

	$('select[name='+id+'].editable, select[id='+id+']').select2({width:'100%'});
	$(document).unbind('keypress').unbind('keydown');
}	
function insert_form_section(form,beforeField,label) 
	{
		jQuery('<tr class="FormData"><td style="padding:5px 0;" colspan="99">' +
		'<div style="padding:3px" class="ui-widget-header ui-corner-all">' +
		'<b>'+label+'</b></div></td></tr>')
		.insertBefore(jQuery('#tr_'+beforeField, form));
	}
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
		
