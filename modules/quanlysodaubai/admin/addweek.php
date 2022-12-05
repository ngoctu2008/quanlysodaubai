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

$xtpl = new XTemplate('addweek.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);


// them nam hoc moi
$page_title = $lang_module['addweek'];
$row = [];
if ($nv_Request->isset_request('btnsubmit', 'post')) {

    $thoigianbatdau = $nv_Request->get_string('thoigianbatdau', 'post', '');
    if (!empty($thoigianbatdau) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoigianbatdau))
    $thoigianbatdau = "";
    if (empty($thoigianbatdau)) {
        $row['thoigianbatdau'] = 0;
    } else {
        $phour = date('H');
        $pmin = date('i');
        unset($m);
        preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoigianbatdau, $m);
        $row['thoigianbatdau'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
    }

    $thoigianketthuc = $nv_Request->get_string('thoigianketthuc', 'post', '');
    if (!empty($thoigianketthuc) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoigianketthuc))
    $thoigianketthuc = "";
    if (empty($thoigianketthuc)) {
        $row['thoigianketthuc'] = 0;
    } else {
        $phour = date('H');
        $pmin = date('i');
        unset($m);
        preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoigianketthuc, $m);
        $row['thoigianketthuc'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
    }

    $row['tunam'] = $nv_Request->get_int('tunam', 'post', '');
    $row['dennam'] = $nv_Request->get_int('dennam', 'post', '');

    //Xu ly luu du lieu  
    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear (
        tunam, dennam, thoigianbatdau, thoigianketthuc) VALUES (
        :tunam, :dennam, :thoigianbatdau, :thoigianketthuc)';
    $sth = $db->prepare($_sql);
    $sth->bindParam(':tunam', $row['tunam'], PDO::PARAM_STR);
    $sth->bindParam(':dennam', $row['dennam'], PDO::PARAM_STR);
    $sth->bindParam(':thoigianbatdau', $row['thoigianbatdau'], PDO::PARAM_STR);
    $sth->bindParam(':thoigianketthuc', $row['thoigianketthuc'], PDO::PARAM_STR);
    $sth->execute(); 

    // tiep tuc goi thang moi them vao de lay id
    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear WHERE tunam='. $row['tunam'] .' AND dennam=' . $row['dennam'].' AND thoigianbatdau=' . $row['thoigianbatdau'] .' AND thoigianketthuc=' . $row['thoigianketthuc']);

    // đổ dữ liệu
    $dataschoolyear = $query->fetch();
    

    $time_per_week = 86400 * 7;
    $time_per_1day = 86400;

    $time_from_day = $row['thoigianbatdau'] ;
    $time_to_day = $row['thoigianketthuc'];

    $sum_time = 0;

    if (date('w',$time_from_day) != 1) {
        for($i = 0; date('w',$time_from_day) != 1; ++$i) {
            $time_from_day -=  $time_per_1day;
        }
    }
    
    $_sqlweek = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_week (manamhoc, tungay, denngay, tentuan) VALUES";
    for ($i = 0; $sum_time <= $time_to_day; $i++) {
        $sum_time = $time_from_day + $i * $time_per_week + $time_per_week - $time_per_1day;
        $tungay = $time_from_day + $i * $time_per_week;
        $denngay = $time_from_day + $i * $time_per_week + $time_per_week - $time_per_1day;
        $tentuan ='Tuần ' . ($i+1);
        if ($sum_time > $time_to_day) 
            $_sqlweek = $_sqlweek . " (". $dataschoolyear['manamhoc'].", ".$tungay.", ".$denngay.", '".$tentuan."');";
        else 
            $_sqlweek = $_sqlweek . " (". $dataschoolyear['manamhoc'].", ".$tungay.", ".$denngay.", '".$tentuan."'),";
    }
    // die($_sqlweek);
    $db->query($_sqlweek);
        

    if ($db) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=schoolyearlist');
    }
}



$xtpl->parse('addweek');
$contents = $xtpl->text('addweek');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
