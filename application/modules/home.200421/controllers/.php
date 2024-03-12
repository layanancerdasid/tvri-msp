<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index()
	{
		$pinjam = "163501-163530";
		/*case 1 : ok*/
		//$kembali = str_replace(" ","","163505-163506 , 163512-163515 ,163518-163520");
		// perkiraan result : 163501-163504, 163507-163511, 163516-163517, 163521-163530
		/*case 2 : ok*/
		// $kembali = str_replace(" ","","163505-163526 , 163528-163529");
		// perkiraan result : 163501-163504, 163527-163527, 163530-163530
		/*case 2 : ok*/
		$kembali = str_replace(" ","","163501-163510");
		// perkiraan result : 163511-163524
		
		
		$a=explode("-",$pinjam);
		$b=explode(",",$kembali);
		$part = array();
		$d = array();
		foreach($b as  $v){
			$c = explode("-",$v);
			for($i=$c[0];$i<=$c[1];$i++) 
				array_push($d, $i);
		}
		// echo json_encode($d); die;
		for($i=$a[0];$i<=$a[1];$i++){
			if(!in_array($i,$d)){
				// catat yg dipinjam
				array_push($part,(int)$i);
				// cek loncat
				// if (count($part)
					// echo $part[count($part)-1]." = ".($i-1)."<br>";
				if(count($part)>2){
					// echo $part[count($part)-1]." - ".($part[count($part)-2])." != "."1"."<br>";
					if(($part[count($part)-1] - $part[count($part)-2]) !== 1 )
						array_push($part,$part[count($part)-1]);
				}
			}
		}
		// echo json_encode($part); die;
		// sort desc
		$d = array();
		for($i=count($part)-1;$i>=0;$i--) $x[] = $part[$i];
		$part = $x;
		
		//literasi distinct range
		$max=0;
		$min=array_pop($part);
		do{
			if($max==0){
				$max = $min;
			}
			if($part[count($part)-1] -$max  == 1){
				$max = $part[count($part)-1];
			}else{
				// echo "catat steletah break ".$min." s/d ".$max."<br>";
				array_push($d, $min."-".$max);
				$min = array_pop($part);
				$max = $part[count($part)-1];
			}
			array_pop($part);
			if(count($part)==0){
				// echo "catat akhir ".$min." s/d ".$max."<br>";
				array_push($d, $min."-".$max);
			}
		}
		while(0<count($part));
		echo json_encode($d);		
	}
	
	function test()
	{
		$part = array(163501,163502,163503,163504,163527,163527,163530,163530);
		// perkiraan result : 163501-163504, 163527-163527, 163530-163530
		// sort desc
		$d = array();
		for($i=count($part)-1;$i>=0;$i--) $x[] = $part[$i];
		$part = $x;
		
		//literasi distinct range
		$max=0;
		$min=array_pop($part);
		do{
			if($max==0){
				$max = $min;
			}
			echo "loop ".$part[count($part)-1]."-".$max."  == 1"."<br>";
			if($part[count($part)-1] -$max  == 1){
				$max = $part[count($part)-1];
			}else{
				echo "catat steletah break ".$min." s/d ".$max."<br>";
				array_push($d, $min."-".$max);
				$min = array_pop($part);
				$max = $part[count($part)-1];
			}
			array_pop($part);
			if(count($part)==0){
				echo "catat akhir ".$min." s/d ".$max."<br>";
				array_push($d, $min."-".$max);
			}
		}
		while(0<count($part));
		echo json_encode($d);
		
		
	}
	
	

}
