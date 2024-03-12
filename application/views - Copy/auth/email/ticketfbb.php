<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Direktorat Pengembangan Pitalebar - Tiket Laporan FBB</title>
	<meta name="description" content="SIPEMPRO (Sistem Informasi Pemantauan Project) sebuah platform aplikasi yang bertujuan untuk melakukan pemantauan project ataupun survei secara realtime dan akurat.">
	<meta name="author" content="KOMINFO Republik Indonesia">
</head>
<body>
	<center>
	<table 	width="600" style="text-align:left;" border="0">
		<tr>
			<td height="18" width="31"  >
				<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
			</td>
			<td height="18" width="131">
				<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
			</td>
			<td height="18" width="466" >
				<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
			</td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align:center;" style="max-width:80px;">
				<img src=<?php echo base_url().'images/navs/kominfo_basic.png'?> style="max-width:80px;" alt=""/></td>
			</td>
			<td>
				<h3 style="margin: 0px; width:466px;" ><b>Laporan Tiket Penerima Bantuan Bantuan Teknologi Informasi dan Komunikasi (TIK)</b></h3>
				Sistem Informasi Pemantauan Proyek Direktorat Pengembangan Pitalebar
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table cellpadding="0" cellspacing="0" border="0" width="600">
					<tr>
						<td width="15" >
							<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
						</td>
						<td width="120" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" valign="top">
							<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
						</td>
						<td width="10" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" valign="top">
							<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
						</td>
						<td width="485" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" valign="top">
							<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
						</td>
						<td width="15" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" valign="top">
							<div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4"><hr/></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<br/>
							<b>Dear <?php echo $to_nama;?>,  </b>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<p>Kami telah menerima pesan <b><?php echo $m_warning;?></b>  dari pengguna Program Penerima Bantuan Teknologi Informasi dan Komunikasi (TIK) Direktorat Pengembangan Pitalebar. Berikut informasi lengkapnya: </p>
						</td>
					</tr>
					<tr>
						<?php echo $m_body;?>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<p><?php echo $m_action;?></p>
						</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							Best Regards <br/>
							<?php echo $br_nama;?> <br/>
							<?php echo $br_jabatan;?> <br/>
							<hr/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;">
							Email ini dikirim otomatis dan ditujukan kepada anda karena anda terdaftar pada Sistem Informasi Pemantauan Proyek Direktorat Pengembangan Pitalebar (<a href="https://ippl.ptmsp.id">SIMPEMPRO</a>)
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
		
	</center>
</body>
</html>