<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Sistem Informasi Pemantauan Proyek Direktorat Pengembangan Pitalebar</title>
	<meta name="description" content="Siwaspang merupakan platform aplikasi android guna membatu mendokumentasikan kegiatan pengawasan lapangan">
	<meta name="author" content="Siwaspang Indonesia">
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
				<h3 style="margin: 0px; width:466px;" ><b>Reminder <?php echo $ivl?></b></h3>
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
							Kepada Yth.
							<br/><?php echo $to_nama;?> 
							<br/>Di tempat
						</td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<br/>
								<p>Sesuai jadwal tahapan kerja (<i>Milestone</i>) yang telah disepakati bersama untuk agenda berikut:</p>
							<br/>
						</td>
					</tr>
					<tr style="vertical-align: text-top;">
						<?php echo $m_body;?>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							<br/>
								<!--<p>Mohon untuk segera menyelesaikan pekerjaan sesuai jadwal yang telah ditetapkan, dan jika sudah selesai mohon diinformasikan  kepada PPK (Pejabat Pembuat Komitmen) dan Tim Terkait disertai <b>bukti penyelesaian pekerjaan</b>.</p>
								-->
								<p>Mohon Segera :
								<ol>
									<li>Menyampaikan bukti pekerjaan kepada PPK dan tim.</li>
									<li>Menyusun dan menyampaikan tagihan pembayaran berdasarkan termin yang disepakati dalam kontrak Kepada PPK dan tim (abaikan jika tidak ada).</li>
								</ol>
								</p>
							<br/>
							<p><font color="red">Apabila ada perubahan jadwal, agar segera melapor ke PPK dan Tim.</font></p>
							<br/>
						</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="4">
							Terima Kasih,<br/>
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