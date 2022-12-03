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
  hocsinhvang longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(hocsinhvang)),
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

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_headbook (masodaubai, matuan, malop, mabuoi, thu, tiet, mamon, tietppct, hocsinhvang, tenbaihoc, nhanxet, diemhoctap, diemkyluat, diemvesinh, tongdiem, giaovienbmkiten, ngay) VALUES (1, 1, 1, 1, 'Thứ 2', 1, 1, 1, '[1, 2, 3, 4, 5]', 'Bài 1 – Khởi động làm quen giao diện ', 'Lớp học tốt', 8.7, 8.5, 8.6, 8, '/quanlysodaubai/uploads/quanlysodaubai/chuki1.png', 1232142114);";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_headbook (masodaubai, matuan, malop, mabuoi, thu, tiet, mamon, tietppct, hocsinhvang, tenbaihoc, nhanxet, diemhoctap, diemkyluat, diemvesinh, tongdiem, giaovienbmkiten, ngay) VALUES (2, 1, 1, 1, 'Thứ 2', 2, 1, 1, '[1, 2, 3, 4, 5]', 'Bài 2 – Thao tác với bảng tính', 'Lớp học hay nói chuỵen nhiều', 9.7, 8, 8, 8.6, '/quanlysodaubai/uploads/quanlysodaubai/chuki2.png', 1232142114);";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_headbook (masodaubai, matuan, malop, mabuoi, thu, tiet, mamon, tietppct, hocsinhvang, tenbaihoc, nhanxet, diemhoctap, diemkyluat, diemvesinh, tongdiem, giaovienbmkiten, ngay) VALUES (3, 1, 1, 1, 'Thứ 5', 3, 1, 1, '[1, 2, 3, 4, 5]', 'Bài 3 – Làm việc với dữ liệu', 'Bạn Huy đánh nhau với bạn Lâm trong lớp', 6.5, 8, 8, 7.5, '/quanlysodaubai/uploads/quanlysodaubai/chuki3.png', 1232142114);";

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



    