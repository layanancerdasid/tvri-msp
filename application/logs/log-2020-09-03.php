<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-09-03 09:03:05 --> 404 Page Not Found: ../modules/transaksi/controllers/Transaksi/%3C
ERROR - 2020-09-03 09:24:47 --> 404 Page Not Found: ../modules/transaksi/controllers/Transaksi/%3C
ERROR - 2020-09-03 09:26:00 --> 404 Page Not Found: ../modules/transaksi/controllers/Transaksi/%3C
ERROR - 2020-09-03 09:34:29 --> 404 Page Not Found: ../modules/auth/controllers/Auth/%3C
ERROR - 2020-09-03 10:30:46 --> 404 Page Not Found: ../modules/pemantauan/controllers/Pemantauan/form_paket
ERROR - 2020-09-03 10:30:46 --> 404 Page Not Found: ../modules/pemantauan/controllers/Pemantauan/form_paket
ERROR - 2020-09-03 10:30:46 --> 404 Page Not Found: ../modules/pemantauan/controllers/Pemantauan/form_paket
ERROR - 2020-09-03 10:30:50 --> 404 Page Not Found: ../modules/pemantauan/controllers/Pemantauan/form_paket
ERROR - 2020-09-03 10:30:50 --> 404 Page Not Found: ../modules/pemantauan/controllers/Pemantauan/form_paket
ERROR - 2020-09-03 10:31:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
														
													) rpt 
													WHERE 1=1' at line 31 - Invalid query: SELECT * FROM (
														SELECT 
															lt.idmilestone
																,rs.idreff
																,ls.idkontrak
																,ls.iduser
																,uj.item dvr
																,uj.keterangan pck
																,CONCAT(lt.nomor,':::',lt.scopeofwork) act
																,lt.bobot 
																,rs.idfoto, rs.tgl_pengujian, rs.catatan, rs.iduser_pengawas, rs.iduser_vendor
																,rs.pathname
																,rs.pathname idx_pathname
																,SUBSTRING_INDEX(rs.pathname,'.',-1) AS extfile
																,rs.pathpengawas
																,rs.pathpengawas idx_pathpengawas
																,SUBSTRING_INDEX(rs.pathpengawas,'.',-1) AS extfile_pengawas
																,rs.hasil
																,lt.platform
																,rs.approveby
																,kat.kategori
																,lt.scopeofwork as lokasi
																,lt.scopeofwork as ftlokasi
																,rs.volume 
															FROM trx_milestone lt
															LEFT JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
															LEFT JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
															LEFT JOIN trx_pengujian uj ON uj.idmilestone=lt.idmilestone
															INNER JOIN trx_foto_ujiactifity rs ON rs.idreff=uj.idpengujian AND rs.jenis='Pengujian'
															LEFT JOIN trx_kategoriuji kat ON kat.idkategoriuji=uj.idkategoriuji
															WHERE lt.idkontrak IN ()
														
													) rpt 
													WHERE 1=1		
ERROR - 2020-09-03 10:31:18 --> Severity: Error --> Call to a member function num_rows() on boolean /home/ptmsp/public_html/ippl/application/modules/pemantauan/models/Pm_model.php 148
ERROR - 2020-09-03 10:31:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
														
													) rpt 
													WHERE 1=1' at line 31 - Invalid query: SELECT * FROM (
														SELECT 
															lt.idmilestone
																,rs.idreff
																,ls.idkontrak
																,ls.iduser
																,uj.item dvr
																,uj.keterangan pck
																,CONCAT(lt.nomor,':::',lt.scopeofwork) act
																,lt.bobot 
																,rs.idfoto, rs.tgl_pengujian, rs.catatan, rs.iduser_pengawas, rs.iduser_vendor
																,rs.pathname
																,rs.pathname idx_pathname
																,SUBSTRING_INDEX(rs.pathname,'.',-1) AS extfile
																,rs.pathpengawas
																,rs.pathpengawas idx_pathpengawas
																,SUBSTRING_INDEX(rs.pathpengawas,'.',-1) AS extfile_pengawas
																,rs.hasil
																,lt.platform
																,rs.approveby
																,kat.kategori
																,lt.scopeofwork as lokasi
																,lt.scopeofwork as ftlokasi
																,rs.volume 
															FROM trx_milestone lt
															LEFT JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
															LEFT JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
															LEFT JOIN trx_pengujian uj ON uj.idmilestone=lt.idmilestone
															INNER JOIN trx_foto_ujiactifity rs ON rs.idreff=uj.idpengujian AND rs.jenis='Pengujian'
															LEFT JOIN trx_kategoriuji kat ON kat.idkategoriuji=uj.idkategoriuji
															WHERE lt.idkontrak IN ()
														
													) rpt 
													WHERE 1=1		
ERROR - 2020-09-03 10:31:21 --> Severity: Error --> Call to a member function num_rows() on boolean /home/ptmsp/public_html/ippl/application/modules/pemantauan/models/Pm_model.php 148
ERROR - 2020-09-03 10:31:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')
														
													) rpt 
													WHERE 1=1' at line 31 - Invalid query: SELECT * FROM (
														SELECT 
															lt.idmilestone
																,rs.idreff
																,ls.idkontrak
																,ls.iduser
																,uj.item dvr
																,uj.keterangan pck
																,CONCAT(lt.nomor,':::',lt.scopeofwork) act
																,lt.bobot 
																,rs.idfoto, rs.tgl_pengujian, rs.catatan, rs.iduser_pengawas, rs.iduser_vendor
																,rs.pathname
																,rs.pathname idx_pathname
																,SUBSTRING_INDEX(rs.pathname,'.',-1) AS extfile
																,rs.pathpengawas
																,rs.pathpengawas idx_pathpengawas
																,SUBSTRING_INDEX(rs.pathpengawas,'.',-1) AS extfile_pengawas
																,rs.hasil
																,lt.platform
																,rs.approveby
																,kat.kategori
																,lt.scopeofwork as lokasi
																,lt.scopeofwork as ftlokasi
																,rs.volume 
															FROM trx_milestone lt
															LEFT JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
															LEFT JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
															LEFT JOIN trx_pengujian uj ON uj.idmilestone=lt.idmilestone
															INNER JOIN trx_foto_ujiactifity rs ON rs.idreff=uj.idpengujian AND rs.jenis='Pengujian'
															LEFT JOIN trx_kategoriuji kat ON kat.idkategoriuji=uj.idkategoriuji
															WHERE lt.idkontrak IN ()
														
													) rpt 
													WHERE 1=1		
ERROR - 2020-09-03 10:31:23 --> Severity: Error --> Call to a member function num_rows() on boolean /home/ptmsp/public_html/ippl/application/modules/pemantauan/models/Pm_model.php 148
ERROR - 2020-09-03 20:41:51 --> Severity: Warning --> session_start(): Failed to decode session object. Session has been destroyed /home/ptmsp/public_html/ippl/system/libraries/Session/Session.php 143
