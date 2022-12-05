<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

if (! defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_setupinfo;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_classlist;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_studentlist;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectlist;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_headbook;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_ppct;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_schoolyear;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_week;";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_setupinfo (
id int(11) NOT NULL AUTO_INCREMENT,
tenSo varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
phong varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
truong varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
tuNam int(11) NOT NULL DEFAULT 0,
denNam int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (id)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_classlist (
maLop int(11) NOT NULL AUTO_INCREMENT,
maGVCN int(11) DEFAULT NULL,
tenLop varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
khoi int(2) NOT NULL,
PRIMARY KEY (maLop)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_studentlist (
maHocSinh int(11) NOT NULL AUTO_INCREMENT,
maLop int(11) DEFAULT NULL,
hoTen varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
ngaySinh int(11) NOT NULL,
gioiTinh varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
soTietNghi int(11) NOT NULL DEFAULT 0,
anhDaiDien varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
PRIMARY KEY (maHocSinh)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_subjectlist (
maMonHoc int(11) NOT NULL AUTO_INCREMENT,
tenMonHoc varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
PRIMARY KEY (maMonHoc)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_headbook (
masodaubai int(11) NOT NULL AUTO_INCREMENT,
matuan int(11) NOT NULL,
malop int(11) NOT NULL,
mabuoi int(1) NOT NULL,
thu varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
tiet int(1) NOT NULL,
mamon int(11) NOT NULL,
tietppct int(11) NOT NULL,
hocsinhvang varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
tenbaihoc varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
nhanxet varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
diemhoctap float NOT NULL,
diemkyluat float NOT NULL,
diemvesinh float NOT NULL,
tongdiem float NOT NULL,
giaovienbmkiten varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
ngay int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (masodaubai)
) ENGINE=MyISAM;";

//Phân phối chương trình
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_ppct (
id int(11) NOT NULL AUTO_INCREMENT,
namHoc varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
khoi int(2) NOT NULL,
maMonHoc int(11) DEFAULT NULL,
tiet int(5) NOT NULL,
tenBaiHoc varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM;";

// năm học
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_schoolyear (
manamhoc int(11) NOT NULL AUTO_INCREMENT,
tunam int(11) NOT NULL,
dennam int(11) NOT NULL,
thoigianbatdau int(11) NOT NULL,
thoigianketthuc int(11) NOT NULL,
PRIMARY KEY (manamhoc)
) ENGINE=MyISAM;";

// tuần
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_week (
matuan int(11) NOT NULL AUTO_INCREMENT,
manamhoc int(11) NOT NULL,
tungay int(11) NOT NULL,
denngay int(11) NOT NULL,
tentuan varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
mota varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
trangthai tinyint(1) NOT NULL DEFAULT 1,
PRIMARY KEY (matuan)
) ENGINE=MyISAM;";



    