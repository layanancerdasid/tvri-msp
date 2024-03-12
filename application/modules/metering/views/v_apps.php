<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/themes/cupertino/jquery-ui.custom.css"></link>  
<link rel="stylesheet" href="<?php echo  base_url() ?>assets/phpgrid/jqgrid/css/ui.jqgrid.css"></link> 
<script src="<?php echo base_url();?>assets/phpgrid/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo  base_url() ?>assets/phpgrid/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>  
<script src="<?php echo  base_url() ?>assets/phpgrid/themes/jquery-ui.custom.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

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
		   // 'Today': [moment(), moment()],
		   // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'This Month': [moment().startOf('month'), moment()],
		   'Last Mont': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		   'This Year': [moment().startOf('year'), moment()]
		},
		locale: {
		  format: 'DD/MM/YYYY'
		}
	});
	$(document).ready(function() {
  $('#daterange').datepicker({
       onSelect : function (dateText, inst) {
          $('#formId').submit(); // <-- SUBMIT
		  
	    var vals = $(this).val();
		var arr_date = vals.split(" - ");
		
		var periode = "start="+arr_date[0]+"&end="+arr_date[1];
		window.location.href = "<?=$page;?>?" + periode;
			
  }});
});
				
		
	
	var start = '<?php echo $f_date_start; ?>';
	if(start!==''){
		var a = '<?php list($dd, $mm, $yyyy) = explode('/',$f_date_start);echo $dd.'/'.$mm.'/'.$yyyy;?>';
		var b = '<?php list($dd, $mm, $yyyy) = explode('/',$f_date_end);echo $dd.'/'.$mm.'/'.$yyyy;?>';
		$('#daterange').val(a+' - '+b);
	}	
	
});

		
</script>


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
 <fieldset> 
 <form style="margin:10px;"class="card-header py-2 py-lg-6 "> 
            <table>
			<tr> 
                <td> Tanggal </td> 
                <td><input type="text" id="datetime" name="datetime"   class="form-control form-control-solid form-control-lg" /> 
	        </tr>
			<tr> 
                <td> Nama Petugas </td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsipetugas; ?>
			</select></td>
	        </tr>  
			<tr> 
                <td> Grup Petugas </td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsigrup; ?>
			</select></td>
	        </tr>  
			<tr> 
                <td> Rekan Kerja </td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsirekan; ?>
			</select></td>
	        </tr>  
			<tr> 
                <td> Grup Rekan Kerja </td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsirekangrup; ?>
			</select></td>
	        </tr>  
			<tr> 
                <td> Dinas Shift </td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsishift; ?>
			</select></td>
	        </tr>  
            <tr> 
                <td> Lokasi</td> 
                <td><select name="idlokasi" id="idlokasi" class="form-control form-control-solid form-control-lg"/>
				<?php echo $opsilokasi; ?>
			</select></td> 
            </tr>  
            <tr> 
                <td> Tanggal </td> 
                <td><input type="text" id="daterange" name="daterange"   class="form-control form-control-solid form-control-lg" /> 
	            </tr>  
                <td>&nbsp;</td> 
                <td><input class="btn btn-primary font-weight-bolder text-uppercase px-4 py-2" type="Submit" id="search_text" value="Submit" /></td> 
            </tr> 
            
            </table>    
			</form>
        </fieldset> 
         
	
	
	
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


		
