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

$page_title = $lang_module['studentlist'];

$classlistid = $nv_Request->get_int('classlistid', 'post,get');

$page_addstudent = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addstudent';
$array = [];

// Gọi csdl để lấy dữ liệu
$querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maLop = '. $classlistid .' ORDER BY hoTen ASC');
// đổ dữ liệu
while ($row = $querystudent->fetch()) {
    $array[$row['mahocsinh']] = $row;
}

$queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist WHERE maLop = ' . $classlistid);
$dataclass = $queryclass->fetch();

$xtpl = new XTemplate('studentlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDSTUDENT', $page_addstudent);


// hien thi du lieu 
if(!empty($array)) { 
    $i = 1;
    foreach ($array as $value) {
        $value['checksess'] = md5($value['mahocsinh'] . NV_CHECK_SESSION);
        $value['stt'] = $i++;
        $value['tenlop'] = $dataclass['tenlop'];
        $value['ngaysinh'] = nv_date('d/m/Y', $value['ngaysinh']);
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addstudent&studentid=' . $value['mahocsinh'];
        $xtpl->assign('DATA', $value);
        $xtpl->parse('studentlist.loop');
    }
}


$xtpl->parse('studentlist');
$contents = $xtpl->text('studentlist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
