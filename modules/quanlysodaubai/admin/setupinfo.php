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

$page_title = $lang_module['setupinfo'];

// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_setupinfo');

// đổ dữ liệu
$data = $query->fetch();

// Xử lý phần lưu form 
$row = [];
// kiểm tra tồn tại 1 req hay k
if ($nv_Request->isset_request('btnsubmit', 'post')) {

    $row['tenso'] = nv_substr($nv_Request->get_title('tenso', 'post', ''), 0, 250);
    $row['phong'] = nv_substr($nv_Request->get_title('phong', 'post', ''), 0, 250);
    $row['truong'] = nv_substr($nv_Request->get_title('truong', 'post', ''), 0, 250);
    $row['tunam'] = $nv_Request->get_int('tunam', 'post', '');
    $row['dennam'] = $nv_Request->get_int('dennam', 'post', '');

  if (!$data) {
    //Xu ly luu du lieu  
    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_setupinfo (
        tenSo, phong, truong, tuNam, denNam) VALUES (
        :tenso, :phong, :truong, :tunam, :dennam)';

    $sth = $db->prepare($_sql);
    $sth->bindParam(':tenso', $row['tenso'], PDO::PARAM_STR);
    $sth->bindParam(':phong', $row['phong'], PDO::PARAM_STR);
    $sth->bindParam(':truong', $row['truong'], PDO::PARAM_STR);
    $sth->bindParam(':tunam', $row['tunam'], PDO::PARAM_STR);
    $sth->bindParam(':dennam', $row['dennam'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if ($exe) {
        # code...
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
  } else {
    $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_setupinfo 
    SET tenSo = :tenso, phong = :phong, truong = :truong, tuNam = :tunam, denNam = :dennam
    WHERE id = '. $data['id'];

    // die($_sql);
    $sth = $db->prepare($_sql);
    $sth->bindParam(':tenso', $row['tenso'], PDO::PARAM_STR);
    $sth->bindParam(':phong', $row['phong'], PDO::PARAM_STR);
    $sth->bindParam(':truong', $row['truong'], PDO::PARAM_STR);
    $sth->bindParam(':tunam', $row['tunam'], PDO::PARAM_STR);
    $sth->bindParam(':dennam', $row['dennam'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if ($exe) {
        # code...
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
  }
  
}


$xtpl = new XTemplate('setupinfo.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);

if ($data) {
    $xtpl->assign('DATA', $data);
}

$xtpl->parse('setupinfo');
$contents = $xtpl->text('setupinfo');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
