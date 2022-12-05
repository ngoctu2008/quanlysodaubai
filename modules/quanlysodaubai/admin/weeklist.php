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
$xtpl = new XTemplate('weeklist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);


$schoolyearid = $nv_Request->get_int('schoolyearid', 'post,get');
// die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE manamhoc=' . $schoolyearid);
// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE manamhoc='.$schoolyearid. ' ORDER BY tungay ASC');

// Đổ dữ liệu
$namhocid;
while ($row = $query->fetch()) {
    $array[$row['matuan']] = $row;
    $namhocid = $row['manamhoc'];
}

    $querynamhoc = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear WHERE manamhoc='.$namhocid);
    $datanamhoc = $querynamhoc->fetch();

// hien thi du lieu 
if($array) {
    
    foreach ($array as $value) {

        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=editweek&schoolyearid='.$value['manamhoc'].'&weekid=' . $value['matuan'];
        $value['namhoc'] = $datanamhoc['tunam'].' - '.$datanamhoc['dennam'];
        $value['tungay'] = nv_date('d/m/Y', $value['tungay']);
        $value['denngay'] = nv_date('d/m/Y', $value['denngay']);
        $value['active'] = $value['trangthai'] == 1 ? 'checked="checked"' : '';
        $value['icon'] = $value['mota'] ? "edit" : "plus";
        $xtpl->assign('DATA', $value);
        $xtpl->parse('weeklist.loop');
    }
}

$xtpl->parse('weeklist');
$contents = $xtpl->text('weeklist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
