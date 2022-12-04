<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 24-06-2011 10:35
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['config_diagram_class'];
$array = [];
//get SQL
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classdiagram ORDER BY soghe');
while ($row = $query->fetch()) {
    $array[$row['soghe']] = $row;
}

$xtpl = new XTemplate('configclassdiagram.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

//hien thi du lieu
$qr = $nv_Request->get_int('id', 'get,post', 0);
if ($qr > 0) {
    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist ORDER BY mahocsinh ASC');
    while ($row = $query->fetch()) {
        $array[$row['mahocsinh']] = $row;
    }
    if (!empty($array)) {
        foreach ($array as $value) {
            $xtpl->assign('DATA_CONFIG', $value);
            $xtpl->parse('configclassdiagram.loop');
        }
    }
}


$xtpl->parse('configclassdiagram');
$contents = $xtpl->text('configclassdiagram');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';