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

$page_title = $lang_module['diagram_class'];
$array = [];
$diagdata = [];
//get SQL
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classdiagram ORDER BY soghe');
while ($row = $query->fetch()) {
    $array[$row['soghe']] = $row;
}

$xtpl = new XTemplate('classdiagram.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

//hien thi du lieu
if (!empty($array)) {
    foreach ($array as $value) {
        if ($value['soghe'] <= 10) {
            $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=configclassdiagram&id=' . $value['soghe'];
            $xtpl->assign('DATA', $value);
            $xtpl->parse('classdiagram.loopdiagram');
        } else {
            $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=configclassdiagram&id=' . $value['soghe'];
            $xtpl->assign('DATA', $value);
            $xtpl->parse('classdiagram.loopdiagram2');
        }
    }
}


$xtpl->parse('classdiagram');
$contents = $xtpl->text('classdiagram');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';