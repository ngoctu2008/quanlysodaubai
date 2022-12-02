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

$page_title = $lang_module['subjectlist'];
$page_addsubject = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject';
$array = [];

// Gọi csdl để lấy dữ liệu
$querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist');

// Đổ dữ liệu
while ($row = $querysubject->fetch()) {
    $array[$row['mamonhoc']] = $row;
}

$xtpl = new XTemplate('subjectlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDSUBJECT', $page_addsubject);

// hien thi du lieu 
if($array) { 
    $i = 1;
    foreach ($array as $value) {
        $value['stt'] = $i++;
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject&subjectid=' . $value['mamonhoc'];
        $xtpl->assign('DATA', $value);
        $xtpl->parse('subjectlist.loop');
    }
}

$xtpl->parse('subjectlist');
$contents = $xtpl->text('subjectlist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
