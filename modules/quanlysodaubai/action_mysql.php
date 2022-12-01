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
maLop int(11) NOT NULL,
maGVCN int(11) DEFAULT NULL,
tenLop varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
khoi int(2) NOT NULL,
PRIMARY KEY (maLop)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_studentlist (
maHocSinh int(11) NOT NULL,
maLop int(11) DEFAULT NULL,
hoTen varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
ngaySinh int(11) NOT NULL,
gioiTinh varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
soTietNghi int(11) NOT NULL DEFAULT 0,
anhDaiDien varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
PRIMARY KEY (maHocSinh)
) ENGINE=MyISAM;";