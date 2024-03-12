<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter General Helpers
 * @author		elektra
 */

// ------------------------------------------------------------------------

if ( ! function_exists('getApiKeyGmaps'))
{
	function getApiKeyGmaps()
	{
		return $this->config->item('apikey_gmap');
	}
}

if ( ! function_exists('encodeAll'))
{
	function encodeAll($str)
	{
		return urlencode(base64_encode(date('dmY').$str));
	}
}



if ( ! function_exists('decodeAll'))
{
	function decodeAll($str)
	{
		return substr(base64_decode(urldecode($str)), 8, strlen(base64_decode(urldecode($str))) );
	}
}


function indonesian_month($month) {
		switch ($month) {
				case "01" : $imonth = "Januari"; break;
				case "02" : $imonth = "Februari"; break;
				case "03" : $imonth = "Maret"; break;
				case "04" : $imonth = "April"; break;
				case "05" : $imonth = "Mei"; break;
				case "06" : $imonth = "Juni"; break;
				case "07" : $imonth = "Juli"; break;
				case "08" : $imonth = "Agustus"; break;
				case "09" : $imonth = "September"; break;
				case "10" : $imonth = "Oktober"; break;
				case "11" : $imonth = "November"; break;
				case "12" : $imonth = "Desember"; break;
				default  : $imonth = "-"; break;
		}
		return $imonth;
}

function cap_descmonthindonesia($periode) {
	/**
		$periode = 'YYYY-MM-DD'
	**/
	return substr($periode,-2).' '.indonesian_month(substr($periode,5,2)).' '.substr($periode,0,4);
}

/**
 * change date format from dd-mm-yyyy become yyyy-mm-dd
 * @param <type> $date
 * @return string
 */
function encode_date($date) {
	if(strlen($date) <9 ) return '';
	if (count(explode('-', $date))==3){
		list($day, $month, $year) = explode('-', $date);
		$new_date = $year . "-" . $month . "-" . $day;
		return $new_date;
	}else return null;
}

/**
 * change date format from yyyy-mm-dd become dd-mm-yyyy
 * @param <type> $date
 * @return string
 */
function decode_date($date) {
		if(strlen($date) <9 ) return '';
		list($year, $month, $day) = explode('-', $date);
		$new_date = $day . "-" . $month . "-" . $year;
		return $new_date;
}

if ( ! function_exists('toHari'))
{
    function toHari($var = '')
    {
        switch($var){
			case 'Sunday':
				$hari_ini = "Minggu";
			break;

			case 'Monday':         
				$hari_ini = "Senin";
			break;

			case 'Tuesday':
				$hari_ini = "Selasa";
			break;

			case 'Wednesday':
				$hari_ini = "Rabu";
			break;

			case 'Thursday':
				$hari_ini = "Kamis";
			break;

			case 'Friday':
				$hari_ini = "Jumat";
			break;

			case 'Saturday':
				$hari_ini = "Sabtu";
			break;
			
			default:
				$hari_ini = "Tidak diketahui";     
			break;
		}
		
		return $hari_ini;
    }   
}


if ( ! function_exists('hast_to_list'))
{
    function hast_to_list($var = '')
    {
			$arr = explode("#", $var);
			$result = "";
			foreach($arr as $a=>$r){
				$n = $a+1;
				$result .= (($n>1) ? "<w:br/>" . $n .". ".trim($r) : $n .". ".trim($r));
			}
			
			return $result;
    }   
}

if ( ! function_exists('char_tgl'))
{
    function char_tgl($var = 0)
    {
			switch($var){
			case "01" : $char = "Satu"; break;
			case "02" : $char = "Dua"; break;
			case "03" : $char = "Tiga"; break;
			case "04" : $char = "Empat"; break;
			case "05" : $char = "Lima"; break;
			case "06" : $char = "Enam"; break;
			case "07" : $char = "Tujuh"; break;
			case "08" : $char = "Delapan"; break;
			case "09" : $char = "Sembilan"; break;
			case "10" : $char = "Sepuluh"; break;
			case "11" : $char = "Sebelas"; break;
			case "12" : $char = "Dua Belas"; break;
			case "13" : $char = "Tiga Belas"; break;
			case "14" : $char = "Empat Belas"; break;
			case "15" : $char = "LimaBelas"; break;
			case "16" : $char = "Enam Belas"; break;
			case "17" : $char = "Tujuh Belas"; break;
			case "18" : $char = "Delapan Belas"; break;
			case "19" : $char = "Sembilan Belas"; break;
			case "20" : $char = "Dua puluh"; break;
			case "21" : $char = "Dua Puluh Satu"; break;
			case "22" : $char = "Dua Puluh Dua"; break;
			case "23" : $char = "Dua Puluh Tiga"; break;
			case "24" : $char = "Dua Puluh Empat"; break;
			case "25" : $char = "Dua Puluh Lima"; break;
			case "26" : $char = "Dua Puluh Enam"; break;
			case "27" : $char = "Dua Puluh Tujuh"; break;
			case "28" : $char = "Dua Puluh Delapan"; break;
			case "29" : $char = "Dua Puluh Sembilan"; break;
			case "30" : $char = "Tiga Puluh"; break;
			case "31" : $char = "Tiga Puluh Satu"; break;
			default:
				$char = "Tidak diketahui";     
			break;
		}
		
		return $char;
    }   
}

if ( ! function_exists('to_bulan'))
{
    function to_bulan($var = 0)
    {
			switch((int)$var){
			case 1 :
				$char = "Januari";
			break;
			
			case 2 :
				$char = "Februari";
			break;
			
			case 3 :
				$char = "Maret";
			break;
			
			case 4 :
				$char = "April";
			break;
			
			case 5 :
				$char = "Mei";
			break;
			
			case 6 :
				$char = "Juni";
			break;
			
			case 7 :
				$char = "Juli";
			break;
			
			case 8 :
				$char = "Agustus";
			break;
			
			case 9 :
				$char = "September";
			break;
			
			case 10 :
				$char = "Oktober";
			break;
			
			case 11 :
				$char = "November";
			break;
			
			case 12 :
				$char = "Desember";
			break;
			
			default:
				$char = "Tidak diketahui";     
			break;
		}
		
			return $char;
    }   
}

if ( ! function_exists('to_ordernumberlist_fromhastag'))
{
    function to_ordernumberlist_fromhastag($string)
    {
			$result = $string;
			$arr = explode("#", $result);
			if(count($arr)>1){
				$result = ""; $no=1;
				foreach($arr as $idx=>$h){
					if(strlen(trim($h))>3){
						$h = str_replace("\n", "<w:br/>", $h);
						$h = str_replace('|', "<w:br/>", $h);
						$result .=  $no .". ".trim($h). "<w:br/>";
						$no++;
					}					
				}
			}
			return $result;
    }   
}

if ( ! function_exists('replace_enter'))
{
    function replace_enter($string)
    {
			$result = $string;
			$result = preg_replace('~\R~u', '</w:t><w:br/><w:t>', $result);
			$result = preg_replace('/[^a-zA-Z0-9\'] @#-<>*()%_+/', '', $result);
			$result = str_replace("\n", "<w:br/>", $result);
			$result = str_replace('|', "<w:br/>", $result);
			return $result;
    }   
}

