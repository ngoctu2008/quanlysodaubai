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


$studentid = $nv_Request->get_int('studentid', 'post,get');

$xtpl = new XTemplate('addstudent.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_UPLOADS_DIR', NV_UPLOADS_DIR);
$xtpl->assign('UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload . '/' . date("Y_m"));
$xtpl->assign('module_name', $module_name);

if ($studentid) {
    // chinh sua 
    $page_title = $lang_module['editstudent'];
    
    $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh = ' . $studentid);

    $student = $querystudent->fetch();

    $arrayclass=[];
    // Gọi csdl để lấy dữ liệu
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist');


    // đổ dữ liệu
    $selectedclass = $student['malop'];
    while ($row = $queryclass->fetch()) {
        $arrayclass[$row['malop']] = $row;
    }

     // hien thi du lieu class drop down
     if(!empty($arrayclass)) { 
        foreach ($arrayclass as $value) {
            $value['key'] = $value['malop'];
            $value['title'] = $value['tenlop'];
            $value['selected'] = $selectedclass == $value['malop'] ? "selected" : "";

            $xtpl->assign('DATA_CLASS', $value);
            $xtpl->parse('addstudent.loopclass');
        }
    }
     // hien thi du lieu sex drop down
    $selectedsex = $student['gioitinh'];
    for ($i = 0; $i <= 2; ++$i) {
        $value = [
            'key' => $i,
            'title' => $lang_module['sex' . $i],
            'selected' => $selectedsex == $lang_module['sex' . $i] ? ' selected="selected"' : ''
        ];
        $xtpl->assign('DATA_SEX', $value);
        $xtpl->parse('addstudent.loopsex');
    }

    //hien thi du lieu form con lai
    if($student) { 
        $student['ngaysinh'] = nv_date('d/m/Y', $student['ngaysinh']);
        $xtpl->assign('DATA', $student);
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['hoten'] = nv_substr($nv_Request->get_title('hoten', 'post', ''), 0, 250);
        // truy vấn mã giáo viên

        $ngaysinh = $nv_Request->get_string('ngaysinh', 'post', '');
        if (!empty($ngaysinh) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngaysinh))
        $ngaysinh = "";
        if (empty($ngaysinh)) {
            $row['ngaysinh'] = 0;
        } else {
            $phour = date('H');
            $pmin = date('i');
            unset($m);
            preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngaysinh, $m);
            $row['ngaysinh'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
        }

        if(!empty($arrayclass)) { 

            foreach ($arrayclass as $value) {
                $row['malop'] = $nv_Request->get_int('class_' . $value['malop'], 'post', '');
            }
            for ($i = 0; $i <= 2; ++$i) {
                $row['gioitinh'] = nv_substr($nv_Request->get_title('sex_' . $i, 'post', ''), 0, 250);
            }
            $row['gioitinh'] = $lang_module['sex' . $row['gioitinh']];
        }

        $row['sotietnghi'] = $nv_Request->get_int('sotietnghi', 'post', '');
        $row['anhdaidien'] = nv_substr($nv_Request->get_title('anhdaidien', 'post', ''), 0, 250);

        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist SET hoTen=:hoten, ngaySinh=:ngaysinh
        , gioiTinh=:gioitinh, maLop=:malop, soTietNghi=:sotietnghi, anhDaiDien=:anhdaidien WHERE maHocSinh=' . $studentid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':hoten', $row['hoten'], PDO::PARAM_STR);
        $sth->bindParam(':ngaysinh', $row['ngaysinh'], PDO::PARAM_STR);
        $sth->bindParam(':gioitinh', $row['gioitinh'], PDO::PARAM_STR);
        $sth->bindParam(':malop', $row['malop'], PDO::PARAM_STR);
        $sth->bindParam(':sotietnghi', $row['sotietnghi'], PDO::PARAM_STR);
        $sth->bindParam(':anhdaidien', $row['anhdaidien'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=studentlist&classlistid=' . $row['malop']);
        }
    } 
} else {
    // them moi
    $page_title = $lang_module['addstudent'];

    $arrayclass=[];
    // Gọi csdl để lấy dữ liệu
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist');


    // đổ dữ liệu
    $i =0;
    $selectedclass;
    while ($row = $queryclass->fetch()) {
        $arrayclass[$row['malop']] = $row;
        if($i ==0)
        {
            $selectedclass = $row['malop'];
        }
        $i++;
    }

     // hien thi du lieu class drop down
     if(!empty($arrayclass)) { 
        foreach ($arrayclass as $value) {
            $value['key'] = $value['malop'];
            $value['title'] = $value['tenlop'];
            $value['selected'] = $selectedclass == $value['malop'] ? "selected" : "";

            $xtpl->assign('DATA_CLASS', $value);
            $xtpl->parse('addstudent.loopclass');
        }
    }
     // hien thi du lieu sex drop down
    $selectedsex = $lang_module['sex0'];
    for ($i = 0; $i <= 2; ++$i) {
        $value = [
            'key' => $i,
            'title' => $lang_module['sex' . $i],
            'selected' => $selectedsex == $lang_module['sex' . $i] ? ' selected="selected"' : ''
        ];
        $xtpl->assign('DATA_SEX', $value);
        $xtpl->parse('addstudent.loopsex');
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['hoten'] = nv_substr($nv_Request->get_title('hoten', 'post', ''), 0, 250);
        // truy vấn mã giáo viên

        $ngaysinh = $nv_Request->get_string('ngaysinh', 'post', '');
        if (!empty($ngaysinh) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngaysinh))
        $ngaysinh = "";
        if (empty($ngaysinh)) {
            $row['ngaysinh'] = 0;
        } else {
            $phour = date('H');
            $pmin = date('i');
            unset($m);
            preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngaysinh, $m);
            $row['ngaysinh'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
        }

        if(!empty($arrayclass)) { 

            foreach ($arrayclass as $value) {
                $row['malop'] = $nv_Request->get_int('class_' . $value['malop'], 'post', '');
            }
            for ($i = 0; $i <= 2; ++$i) {
                $row['gioitinh'] = nv_substr($nv_Request->get_title('sex_' . $i, 'post', ''), 0, 250);
            }
            $row['gioitinh'] = $lang_module['sex' . $row['gioitinh']];
        }

        $row['sotietnghi'] = $nv_Request->get_int('sotietnghi', 'post', '');
        $row['anhdaidien'] = nv_substr($nv_Request->get_title('anhdaidien', 'post', ''), 0, 250);

        //Xu ly luu du lieu  
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist (
            hoTen, ngaySinh, gioiTinh, maLop, soTietNghi, anhDaiDien) VALUES (
            :hoten, :ngaysinh, :gioitinh, :malop, :sotietnghi, :anhdaidien)';
        $sth = $db->prepare($_sql);
        $sth->bindParam(':hoten', $row['hoten'], PDO::PARAM_STR);
        $sth->bindParam(':ngaysinh', $row['ngaysinh'], PDO::PARAM_STR);
        $sth->bindParam(':gioitinh', $row['gioitinh'], PDO::PARAM_STR);
        $sth->bindParam(':malop', $row['malop'], PDO::PARAM_STR);
        $sth->bindParam(':sotietnghi', $row['sotietnghi'], PDO::PARAM_STR);
        $sth->bindParam(':anhdaidien', $row['anhdaidien'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=studentlist&classlistid=' . $row['malop']);
        }
    } 

}


$xtpl->parse('addstudent');
$contents = $xtpl->text('addstudent');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
