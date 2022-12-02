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

$subjectid = $nv_Request->get_int('subjectid', 'post,get');

$xtpl = new XTemplate('addsubject.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if ($subjectid) {
    // chinh sua 
    $page_title = $lang_module['editsubject'];
    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist WHERE maMonHoc = ' . $subjectid);
    $subject = $querysubject->fetch();
    if($subject) { 
        $xtpl->assign('DATA', $subject);
    }
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['tenmonhoc'] = nv_substr($nv_Request->get_title('tenmonhoc', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist SET tenMonHoc=:tenmonhoc WHERE maMonHoc=' . $subjectid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':tenmonhoc', $row['tenmonhoc'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=subjectlist');
        }
    } 
} else {
    // Thêm mới
    $page_title = $lang_module['addsubject'];
    $i = 0;
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['tenmonhoc'] = nv_substr($nv_Request->get_title('tenmonhoc', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist (
            tenMonHoc) VALUES (:tenmonhoc)';
        $sth = $db->prepare($_sql);
        $sth->bindParam(':tenmonhoc', $row['tenmonhoc'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=subjectlist');
        }
    } 

}

$xtpl->parse('addsubject');
$contents = $xtpl->text('addsubject');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
