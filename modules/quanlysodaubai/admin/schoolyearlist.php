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


$page_title = $lang_module['schoolyearlist'];
$page_addschoolyear = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addweek';
// $page_studentlist = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=studentlist';
$array = [];

// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear ORDER BY thoigianbatdau ASC');
// đổ dữ liệu 
while ($row = $query->fetch()) {
    $array[$row['manamhoc']] = $row;
}

$xtpl = new XTemplate('schoolyearlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDSCHOOLYEAR', $page_addschoolyear);
// $xtpl->assign('PAGE_STUDENTLIST', $page_studentlist);

// hien thi du lieu 
if(!empty($array)) { 
    foreach ($array as $value) {
        $value['url_weeklist'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE .'=weeklist&schoolyearid=' . $value['manamhoc'] ;
        $value['checksess'] = md5($value['manamhoc'] . NV_CHECK_SESSION);
        $value['thoigianbatdau'] = nv_date('d/m/Y', $value['thoigianbatdau']);
        $value['thoigianketthuc'] = nv_date('d/m/Y', $value['thoigianketthuc']);
        $value['namhoc'] = $value['tunam'] . ' - ' .  $value['dennam'] ;
        $xtpl->assign('DATA', $value);
        $xtpl->parse('schoolyearlist.loop');
    }
}

$xtpl->parse('schoolyearlist');
$contents = $xtpl->text('schoolyearlist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
