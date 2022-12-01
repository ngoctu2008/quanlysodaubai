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


$classlistid = $nv_Request->get_int('id', 'post,get');

$xtpl = new XTemplate('addclass.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
// day la chinh sua form
if ($classlistid) {
    $page_title = $lang_module['editclass'];
    $arrayteacher=[];
    $queryteacher = $db->query('SELECT * FROM nv4_users WHERE group_id = 4 ORDER BY last_name ASC');

    while ($row = $queryteacher->fetch()) {
        $arrayteacher[$row['userid']] = $row;
    }

    
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist WHERE maLop = ' . $classlistid);

    $class = $queryclass->fetch();

    $selected = $class['magvcn'];

    if ($class) {
        $xtpl->assign('CLASS', $class);
    }
    if(!empty($arrayteacher)) { 
        foreach ($arrayteacher as $value) {
            $value['key'] = $value['userid'];
            $value['title'] = $value['first_name'] . ' ' . $value['last_name'];
            $value['selected'] = $selected == $value['userid'] ? "selected" : "";

            $xtpl->assign('DATA', $value);
            $xtpl->parse('addclass.loop');
        }
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['tenlop'] = nv_substr($nv_Request->get_title('tenlop', 'post', ''), 0, 250);
        // truy vấn mã giáo viên
        if(!empty($arrayteacher)) { 

            foreach ($arrayteacher as $value) {
                $row['gvcn'] = $nv_Request->get_int('gvcn_' . $value['userid'], 'post', '');
            }
        }
        $row['khoi'] = $nv_Request->get_int('khoi', 'post', '');

        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_classlist 
        SET tenLop = :tenlop, maGVCN = :gvcn, khoi = :khoi WHERE maLop = '. $classlistid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':tenlop', $row['tenlop'], PDO::PARAM_STR);
        $sth->bindParam(':gvcn', $row['gvcn'], PDO::PARAM_STR);
        $sth->bindParam(':khoi', $row['khoi'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=classlist');
        }
    }


}
//day la add form moi
else {
    $page_title = $lang_module['addclass'];
    $array=[];
    // Gọi csdl để lấy dữ liệu
    $queryteacher = $db->query('SELECT * FROM nv4_users WHERE group_id = 4 ORDER BY last_name ASC');
    // đổ dữ liệu
    $i =0;
    $selected;
    while ($row = $queryteacher->fetch()) {
        $array[$row['userid']] = $row;
        if($i ==0)
        {
            $selected = $row['userid'];
        }
        $i++;
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['tenlop'] = nv_substr($nv_Request->get_title('tenlop', 'post', ''), 0, 250);
        // truy vấn mã giáo viên
        if(!empty($array)) { 

            foreach ($array as $value) {
                $row['gvcn'] = $nv_Request->get_int('gvcn_' . $value['userid'], 'post', '');
            }
        }
        $row['khoi'] = $nv_Request->get_int('khoi', 'post', '');

        //Xu ly luu du lieu  
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_classlist (
            tenLop, maGVCN, khoi) VALUES (
            :tenlop, :gvcn, :khoi)';
        $sth = $db->prepare($_sql);
        $sth->bindParam(':tenlop', $row['tenlop'], PDO::PARAM_STR);
        $sth->bindParam(':gvcn', $row['gvcn'], PDO::PARAM_STR);
        $sth->bindParam(':khoi', $row['khoi'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=classlist');
        }
    } 

    // hien thi du lieu 
    if(!empty($array)) { 
        foreach ($array as $value) {
            $value['key'] = $value['userid'];
            $value['title'] = $value['first_name'] . ' ' . $value['last_name'];
            $value['selected'] = $selected == $value['userid'] ? "selected" : "";

            $xtpl->assign('DATA', $value);
            $xtpl->parse('addclass.loop');
        }
    }
    
}


// $arrclass = [];
// if ($classlistid) {
//     // Gọi csdl để lấy dữ liệu
//     $queryteacher = $db->query('SELECT * FROM nv4_users WHERE group_id = 4 ORDER BY last_name ASC');
//     // đổ dữ liệu
//     $i =0;
//     $selected;
//     while ($row = $queryteacher->fetch()) {
//         $arrclass[$row['userid']] = $row;
//         if($i ==0)
//         {
//             $selected = $row['userid'];
//         }
//     }
// }







$xtpl->parse('addclass');
$contents = $xtpl->text('addclass');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
