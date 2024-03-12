<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-12-01 10:48:07 --> Severity: error --> Exception: Class 'TemplateProcessor' not found C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 742
ERROR - 2020-12-01 10:48:18 --> Severity: error --> Exception: Class 'TemplateProcessor' not found C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 742
ERROR - 2020-12-01 10:48:43 --> Severity: error --> Exception: Class 'TemplateProcessor' not found C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 742
ERROR - 2020-12-01 10:50:29 --> Severity: error --> Exception: Call to undefined method M_konsep::tgl() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 676
ERROR - 2020-12-01 10:50:40 --> Severity: error --> Exception: Call to undefined method M_konsep::tgl() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 676
ERROR - 2020-12-01 10:53:34 --> Query error: Unknown column 'idkakk' in 'where clause' - Invalid query: SELECT `idkak`, `unit_kerja`, `nama_kegiatan`, `program`, `sasaran_program`, `indikator_kinerja`, `thn_anggaran`, `sasaran_kegiatan`, `indikator_kegiatan`, `keluaran`, `indikator_keluaran`, `volume_keluaran`, `satuan_ukur`, `dasar_hukum`, `gambaran_kegiatan`, `penerima_manfaat`, `strategi_pencapaian`, `sumber_dana`, `perkiraan_biaya`, `ms_satker_tvri`.`nama_satker`
FROM `trx_kak`
LEFT JOIN `ms_satker_tvri` ON `ms_satker_tvri`.`idsatker` = `trx_kak`.`unit_kerja`
WHERE `idkakk` = '1'
ERROR - 2020-12-01 10:56:02 --> Severity: error --> Exception: syntax error, unexpected '*' C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 684
ERROR - 2020-12-01 10:56:30 --> Severity: error --> Exception: syntax error, unexpected '*' C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 668
ERROR - 2020-12-01 10:58:44 --> Severity: error --> Exception: Call to undefined method M_konsep::tgl() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 676
ERROR - 2020-12-01 10:59:08 --> Severity: error --> Exception: Call to undefined method M_konsep::tgl() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 676
ERROR - 2020-12-01 10:59:29 --> Severity: error --> Exception: Call to undefined method M_konsep::tgl() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 676
ERROR - 2020-12-01 10:59:59 --> Severity: Warning --> readfile(): Filename cannot be empty C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 672
ERROR - 2020-12-01 10:59:59 --> Severity: Warning --> unlink(): Invalid argument C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 673
ERROR - 2020-12-01 11:01:01 --> Severity: Warning --> readfile(): Filename cannot be empty C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 684
ERROR - 2020-12-01 11:01:02 --> Severity: Warning --> unlink(): Invalid argument C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 685
ERROR - 2020-12-01 11:30:29 --> Query error: Unknown column 'indikator_kinerja_kegiatan' in 'field list' - Invalid query: SELECT `idkak`, `unit_kerja`, `nama_kegiatan`, `program`, `sasaran_program`, `indikator_kinerja`, `thn_anggaran`, `sasaran_kegiatan`, `keluaran`, `indikator_kegiatan`, `keluaran`, `indikator_keluaran`, `volume_keluaran`, `satuan_ukur`, `dasar_hukum`, `gambaran_kegiatan`, `indikator_kinerja_kegiatan`, `penerima_manfaat`, `strategi_pencapaian`, `sumber_dana`, `perkiraan_biaya`, `ms_satker_tvri`.`nama_satker`
FROM `trx_kak`
LEFT JOIN `ms_satker_tvri` ON `ms_satker_tvri`.`idsatker` = `trx_kak`.`unit_kerja`
WHERE `idkak` = '1'
ERROR - 2020-12-01 11:30:46 --> Query error: Unknown column 'indikator_kinerja_kegiatan' in 'field list' - Invalid query: SELECT `idkak`, `unit_kerja`, `nama_kegiatan`, `program`, `sasaran_program`, `indikator_kinerja`, `thn_anggaran`, `sasaran_kegiatan`, `keluaran`, `indikator_kegiatan`, `indikator_keluaran`, `volume_keluaran`, `satuan_ukur`, `dasar_hukum`, `gambaran_kegiatan`, `indikator_kinerja_kegiatan`, `penerima_manfaat`, `strategi_pencapaian`, `sumber_dana`, `perkiraan_biaya`, `ms_satker_tvri`.`nama_satker`
FROM `trx_kak`
LEFT JOIN `ms_satker_tvri` ON `ms_satker_tvri`.`idsatker` = `trx_kak`.`unit_kerja`
WHERE `idkak` = '1'
ERROR - 2020-12-01 11:31:43 --> Query error: Unknown column 'indikator_kinerja_kegiatan' in 'field list' - Invalid query: SELECT `idkak`, `unit_kerja`, `nama_kegiatan`, `program`, `sasaran_program`, `indikator_kinerja`, `thn_anggaran`, `sasaran_kegiatan`, `keluaran`, `indikator_keluaran`, `volume_keluaran`, `satuan_ukur`, `dasar_hukum`, `gambaran_kegiatan`, `indikator_kinerja_kegiatan`, `penerima_manfaat`, `strategi_pencapaian`, `sumber_dana`, `perkiraan_biaya`, `ms_satker_tvri`.`nama_satker`
FROM `trx_kak`
LEFT JOIN `ms_satker_tvri` ON `ms_satker_tvri`.`idsatker` = `trx_kak`.`unit_kerja`
WHERE `idkak` = '1'
ERROR - 2020-12-01 13:06:14 --> Severity: error --> Exception: Call to a member function data_konsep() on null C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 649
ERROR - 2020-12-01 13:07:11 --> Severity: error --> Exception: Call to a member function data_konsep() on null C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 649
ERROR - 2020-12-01 13:10:12 --> Severity: error --> Exception: Call to a member function data_konsep() on null C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 649
ERROR - 2020-12-01 13:58:48 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 13:59:26 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:00:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL' at line 2 - Invalid query: SELECT *, COUNT(*) as count
WHERE  IS NULL
ERROR - 2020-12-01 14:01:36 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:01:44 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:02:05 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:02:19 --> Query error: Unknown column 'llll' in 'order clause' - Invalid query: SELECT *, COUNT(*) as count
FROM `trx_rab`
WHERE `idkak` = '1'
ORDER BY `llll`
ERROR - 2020-12-01 14:03:19 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:03:32 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:04:18 --> Query error: Unknown column 'ooo' in 'order clause' - Invalid query: SELECT *, COUNT(*) as count
FROM `trx_rab`
WHERE `idkak` = '1'
ORDER BY `ooo`
ERROR - 2020-12-01 14:04:39 --> Query error: Unknown column 'idrab' in 'order clause' - Invalid query: SELECT *, COUNT(*) as count
FROM `trx_lampiran`
WHERE `idkak` = '1'
ORDER BY `idrab`
ERROR - 2020-12-01 14:05:14 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:05:42 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:06:05 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:08:02 --> Severity: error --> Exception: syntax error, unexpected '$dt_lembaga' (T_VARIABLE) C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 650
ERROR - 2020-12-01 14:08:17 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 650 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:09:58 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 648 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:10:21 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:10:37 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:11:06 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:11:28 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:11:50 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:11:56 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:12:28 --> Severity: error --> Exception: Call to undefined method M_konsep::data_lembaga() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 649
ERROR - 2020-12-01 14:13:06 --> Severity: error --> Exception: Call to undefined method M_konsep::data_lembaga() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 649
ERROR - 2020-12-01 14:13:32 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:13:37 --> Severity: error --> Exception: Too few arguments to function M_konsep::data_lembaga(), 1 passed in C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php on line 649 and exactly 4 expected C:\xampp\htdocs\tvri\application\models\M_konsep.php 17
ERROR - 2020-12-01 14:15:53 --> Severity: error --> Exception: Call to undefined method M_konsep::data_rab() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 648
ERROR - 2020-12-01 14:16:19 --> Severity: error --> Exception: Call to undefined method M_konsep::data_rab() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 648
ERROR - 2020-12-01 14:16:39 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 700
ERROR - 2020-12-01 14:18:36 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 700
ERROR - 2020-12-01 14:33:59 --> Severity: error --> Exception: Call to a member function result() on null C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:37:08 --> Severity: error --> Exception: Call to a member function result() on null C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:40:19 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:44:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:46:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:47:19 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:48:01 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:49:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:51:15 --> Severity: error --> Exception: Can not clone row, template variable not found or variable contains markup. C:\xampp\htdocs\tvri\assets\vendor\phpoffice\phpword\src\PhpWord\TemplateProcessor.php 667
ERROR - 2020-12-01 14:51:27 --> Severity: error --> Exception: Can not clone row, template variable not found or variable contains markup. C:\xampp\htdocs\tvri\assets\vendor\phpoffice\phpword\src\PhpWord\TemplateProcessor.php 667
ERROR - 2020-12-01 14:51:47 --> Severity: error --> Exception: Can not clone row, template variable not found or variable contains markup. C:\xampp\htdocs\tvri\assets\vendor\phpoffice\phpword\src\PhpWord\TemplateProcessor.php 667
ERROR - 2020-12-01 14:54:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:55:00 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:55:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:55:54 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 14:56:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 699
ERROR - 2020-12-01 15:20:44 --> Severity: Warning --> Parameter 1 to setRAB() expected to be a reference, value given C:\xampp\htdocs\tvri\application\libraries\phpgrid\jqgrid_dist.php 2613
ERROR - 2020-12-01 15:42:42 --> Severity: error --> Exception: Call to undefined function money_format() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 709
ERROR - 2020-12-01 15:42:58 --> Severity: error --> Exception: Call to undefined function money_format() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 709
ERROR - 2020-12-01 15:44:48 --> Severity: error --> Exception: Call to undefined function money_format() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 709
ERROR - 2020-12-01 15:45:21 --> Severity: error --> Exception: Call to undefined function money_format() C:\xampp\htdocs\tvri\application\modules\kak\controllers\Kak.php 704
ERROR - 2020-12-01 20:36:03 --> Severity: Warning --> Use of undefined constant list7 - assumed 'list7' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\tvri\application\modules\transmisi\controllers\Transmisi.php 1601
ERROR - 2020-12-01 20:36:04 --> Severity: Warning --> Use of undefined constant list7 - assumed 'list7' (this will throw an Error in a future version of PHP) C:\xampp\htdocs\tvri\application\modules\transmisi\controllers\Transmisi.php 1601
ERROR - 2020-12-01 20:37:23 --> Severity: Warning --> call_user_func_array() expects parameter 1 to be a valid callback, class 'Master' does not have a method 'page_not_found' C:\xampp\htdocs\tvri\system\core\CodeIgniter.php 532
ERROR - 2020-12-01 20:37:24 --> Severity: Warning --> call_user_func_array() expects parameter 1 to be a valid callback, class 'Master' does not have a method 'page_not_found' C:\xampp\htdocs\tvri\system\core\CodeIgniter.php 532
ERROR - 2020-12-01 20:37:24 --> Severity: Warning --> call_user_func_array() expects parameter 1 to be a valid callback, class 'Master' does not have a method 'page_not_found' C:\xampp\htdocs\tvri\system\core\CodeIgniter.php 532
