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

$page_title = $lang_module['classlist'];
$page_addclass = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addclass';
// $page_studentlist = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=studentlist';
$array = [];

// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist ORDER BY tenLop ASC');
// đổ dữ liệu 
while ($row = $query->fetch()) {
    $array[$row['malop']] = $row;
}



$xtpl = new XTemplate('classlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDCLASS', $page_addclass);
// $xtpl->assign('PAGE_STUDENTLIST', $page_studentlist);

// hien thi du lieu 
if(!empty($array)) { 
    foreach ($array as $value) {
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addclass&id=' . $value['malop'];
        $value['url_studentlist'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE .'=studentlist&classlistid=' . $value['malop'] ;
        $value['checksess'] = md5($value['malop'] . NV_CHECK_SESSION);
        // die('SELECT * FROM nv4_users WHERE userid = ' . $value['magvcn']);
        $queryteacher = $db->query('SELECT * FROM nv4_users WHERE userid = ' . $value['magvcn'] );
        $rowteacher = $queryteacher->fetch();

        $value['teacher'] = $rowteacher['first_name'] . ' ' . $rowteacher['last_name'];
        $xtpl->assign('DATA', $value);
        $xtpl->parse('classlist.loop');
    }
}


$xtpl->parse('classlist');
$contents = $xtpl->text('classlist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
