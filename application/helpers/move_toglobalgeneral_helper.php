<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function test_method($var = '')
    {
        return $var;
    }   
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

			case 'Thursday':
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
			case 01 :
				$char = "Satu";
			break;
			
			case 02 :
				$char = "Dua";
			break;
			
			case 03 :
				$char = "Tiga";
			break;
			
			case 04 :
				$char = "Empat";
			break;
			
			case 05 :
				$char = "Lima";
			break;
			
			case 06 :
				$char = "Enam";
			break;
			
			case 07 :
				$char = "Tujuh";
			break;
			
			case 08 :
				$char = "Delapan";
			break;
			
			case 09 :
				$char = "Sembilan";
			break;
			
			case 10 :
				$char = "Sepuluh";
			break;
			
			case 11 :
				$char = "Sebelas";
			break;
			
			case 12 :
				$char = "Dua Belas";
			break;
			
			case 13 :
				$char = "Tiga Belas";
			break;
			
			case 14 :
				$char = "Empat Belas";
			break;
			
			case 15 :
				$char = "LimaBelas";
			break;
			
			case 16 :
				$char = "Enam Belas";
			break;
			
			case 17 :
				$char = "Tujuh Belas";
			break;
			
			case 18 :
				$char = "Delapan Belas";
			break;
			
			case 19 :
				$char = "Sembilan Belas";
			break;
			
			case 20 :
				$char = "Dua puluh";
			break;
			
			case 21 :
				$char = "Dua Puluh Satu";
			break;
			
			case 22 :
				$char = "Dua Puluh Dua";
			break;
			
			case 23 :
				$char = "Dua Puluh Tiga";
			break;
			
			case 24 :
				$char = "Dua Puluh Empat";
			break;
			
			case 25 :
				$char = "Dua Puluh Lima";
			break;
			
			case 26 :
				$char = "Dua Puluh Enam";
			break;
			
			case 27 :
				$char = "Dua Puluh Tujuh";
			break;
			
			case 28 :
				$char = "Dua Puluh Delapan";
			break;
			
			case 29 :
				$char = "Dua Puluh Sembilan";
			break;
			
			case 30 :
				$char = "Tiga Puluh";
			break;
			
			case 31 :
				$char = "Tiga Puluh Satu";
			break;
			
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
			switch($var){
			case 01 :
				$char = "Januari";
			break;
			
			case 02 :
				$char = "Februari";
			break;
			
			case 03 :
				$char = "Maret";
			break;
			
			case 04 :
				$char = "April";
			break;
			
			case 05 :
				$char = "Mei";
			break;
			
			case 06 :
				$char = "Juni";
			break;
			
			case 07 :
				$char = "Juli";
			break;
			
			case 08 :
				$char = "Agustus";
			break;
			
			case 09 :
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