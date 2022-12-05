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

$weekid = $nv_Request->get_int('weekid', 'post,get');
$schoolyearid = $nv_Request->get_int('schoolyearid', 'post,get');


$page_title = $lang_module['editweek'];


$xtpl = new XTemplate('editweek.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if ($weekid) {
    // chinh sua 
    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE matuan = ' . $weekid);
    $week = $queryweek->fetch();
    if($week) { 
        $xtpl->assign('DATA', $week);
    }
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['mota'] = nv_substr($nv_Request->get_title('mota', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_week SET mota=:mota WHERE matuan=' . $weekid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':mota', $row['mota'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=weeklist&schoolyearid='.$schoolyearid);
        }
    } 
}

$xtpl->parse('editweek');
$contents = $xtpl->text('editweek');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
