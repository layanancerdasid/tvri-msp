
/**
 * Requeirement jquery.numberjs
 * Example : 
 *			$col["editrules"] = array("required"=>false, "custom"=>true,"custom_func"=>"function(val,label){return my_validation(val,label);}");  
 * 			$col["editoptions"] = array("onfocus"=>"set_field_number(this)", "style"=>"text-align:right"); 
 */

function set_field_number0(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).number(true,0);
}

function set_field_number1(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).number(true,1);
}

function set_field_number2(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).number(true,2);
}


/**
 * Requeirement jquery.maskedinput.min.js
 * Example : 
 *			$col["editrules"] = array("required"=>false, "custom"=>true,"custom_func"=>"function(val,label){return my_validation(val,label);}");  
 * 			$col["editoptions"] = array("onfocus"=>"set_mask_npwp(this)", "style"=>"text-align:right"); 
 */
 
function set_mask_npwp(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("99.999.999.9-999.999");
}

function set_mask_telp(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("999 99999 9999");
}

function set_mask_tokenlistrik(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("99 9999 9999 9");
}

function set_mask_debit(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("9999 9999 9999 9999");
}

function set_mask_nik(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("9999999999999999");
}

function set_mask_years(o) 
{ 
	if(jQuery('#'+o.id).length>0) $('#'+o.id).mask("9999");
}

