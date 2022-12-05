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

$manamhoc_get = $nv_Request->get_int('manamhoc', 'post,get');
$matuan_get = $nv_Request->get_int('matuan', 'post,get');
$malop_get = $nv_Request->get_int('malop', 'post,get');
$mabuoi_get = $nv_Request->get_int('mabuoi', 'post,get');


$page_title = $lang_module['manage_headbook'];

$xtpl = new XTemplate('manageheadbook.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('MANAMHOC', $manamhoc_get);
$xtpl->assign('MATUAN', $matuan_get);
$xtpl->assign('MALOP', $malop_get);
$xtpl->assign('MABUOI', $mabuoi_get);


$display_form = 'style="display: none"';
//nam hoc

if($nv_Request->isset_request("change_schoolyear","post,get")) {
    $manamhoc = $nv_Request->get_int('manamhoc','get',0);
    // Subject
    if ($manamhoc > 0) {
        $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE manamhoc='.$manamhoc.' ORDER BY tungay ASC');
        $html = '';
        while ($row = $queryweek->fetch()) {
            $html .= '<option value="' . $row['matuan'] . '">' . $row['tentuan'].' ('.nv_date('d/m/Y', $row['tungay']). ' - '.nv_date('d/m/Y', $row['denngay']).')' . '</option>';
        }
        die($html);
    } else {
        die("ERR");
    }
}


// lop 
$queryschoolyear = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear ORDER BY tunam ASC');

$selectedschoolyear=$manamhoc_get ? $manamhoc_get : 0;
$arrayschoolyear = [];
while ($row = $queryschoolyear->fetch()) {
    $arrayschoolyear[$row['manamhoc']] = $row;
}

// hien thi du lieu hócinh
if(!empty($arrayschoolyear)) {
    foreach ($arrayschoolyear as $value) {
        $value['key'] = $value['manamhoc'];
        $value['title'] = $value['tunam'] . ' - ' . $value['dennam'];
        $value['selected'] = $selectedschoolyear == $value['manamhoc'] ? "selected" : "";
        $xtpl->assign('DATA_SCHOOLYEAR', $value);
        $xtpl->parse('manageheadbook.loopschoolyear');
    }
}

// lop 
$queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist ORDER BY tenLop ASC');

$selectedclass= $malop_get ? $malop_get : 0;
$arrayclass = [];
while ($row = $queryclass->fetch()) {
    $arrayclass[$row['malop']] = $row;
}

// hien thi du lieu hócinh
if(!empty($arrayclass)) {
    foreach ($arrayclass as $value) {
        $value['key'] = $value['malop'];
        $value['title'] = $value['tenlop'];
        $value['selected'] = $selectedclass == $value['malop'] ? "selected" : "";
        $xtpl->assign('DATA_CLASS', $value);
        $xtpl->parse('manageheadbook.loopclass');
    }
}

$selectedday = $mabuoi_get ? $mabuoi_get : 0;
$data=[];
for ($i=1; $i <=2 ; $i++) { 
    $data['key'] = $i;
    $data['title'] = $lang_module['daystatus'.$i];
    $data['selected'] = $selectedday == $i ? "selected" : "";
    $xtpl->assign('DATA_DAYSTUS', $data);
    $xtpl->parse('manageheadbook.loopdaystatus');
}

// tuan
if($matuan_get) {
    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE manamhoc ='.$manamhoc_get .' ORDER BY tungay ASC');
    // o day phai doi tim duoc hoc sinh nghi
    $selectedweek=$matuan_get;
    $arrayweek = [];
    while ($row = $queryweek->fetch()) {
        $arrayweek[$row['matuan']] = $row;
    }

    // hien thi du lieu hócinh
    if(!empty($arrayweek)) {
        foreach ($arrayweek as $value) {
            $value['key'] = $value['matuan'];
            $value['title'] = $value['tentuan'] .' ('.nv_date('d/m/Y', $value['tungay']). ' - '.nv_date('d/m/Y', $value['denngay']).')';
            $value['selected'] = $selectedweek == $value['matuan'] ? "selected" : "";

            $xtpl->assign('DATA_WEEK', $value);
            $xtpl->parse('manageheadbook.loopweek');
        }
    }
}

$querytungay = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE manamhoc ='.$manamhoc_get . ' AND matuan='.$matuan_get);

$datatungay = $querytungay->fetch();
$currenttime = $datatungay['tungay'];

if($manamhoc_get > 0 && $malop_get > 0 && $mabuoi_get >0 && $matuan_get >0) {
    for ($i=2; $i <= 8; $i++){
    


        $array = [];
    
        // Gọi csdl để lấy dữ liệu
        
        $query = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE matuan=".$matuan_get." AND malop=".$malop_get." AND mabuoi=".$mabuoi_get." AND thu LIKE 'Th%". $i ."' ORDER BY tiet ASC");
        // đổ dữ liệu 
        while ($row = $query->fetch()) {
            $array[$row['tiet']] = $row;
        }
    
    
        if ($array) {
            for ($j = 1; $j <= 5; $j++) {
                $value = $array[$j];
                $day = '';
                if ($j == 1) {
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
                }
                if ($value) {
                    $value['checksess'] = md5($value['masodaubai'] . NV_CHECK_SESSION);
                    $value['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&manamhoc='.$manamhoc_get.'&matuan=' . $matuan_get . '&malop='.$malop_get. '&mabuoi='.$mabuoi_get. '&thu='.$i . '&tiet='.$value['tiet'] . '&id='.$value['masodaubai'];
    
                    // lay ra mon hoc
                    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist WHERE maMonHoc=' . $value['mamon']);
                    $datasubject = $querysubject->fetch();
                    $value['tenmonhoc'] = $datasubject['tenmonhoc'];
    
                    // chuyen thanh array
                    $arrabsent = explode(",", $value['hocsinhvang']);
                    $value['tenhocsinhnghi'] = '';
                    // lay ra may thang nghi
    
                    $last_key = end(array_keys($arrabsent));
                    foreach ($arrabsent as $key => $mahocsinh) {
                        // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                        $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                        $dataabsent = $queryabsent->fetch();
                        if ($key == $last_key) {
                            $value['tenhocsinhnghi'] .= $dataabsent['hoten'];
                        } else {
                            $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ', ';
                        }
                    }
    
                    $xtpl->assign('DISPLAY_ADD', 'none');
                    $xtpl->assign('DISPLAY_EDIT', 'block');
    
                    $xtpl->assign('DISPLAY_ADD', 'none');
                    $xtpl->assign('DISPLAY_EDIT', 'block');
                    $xtpl->assign('DISPLAY_IMG', 'block');
                } else {
    
                    $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&manamhoc='.$manamhoc_get.'&matuan='.$matuan_get.'&malop='.$malop_get.'&mabuoi='.$mabuoi_get.'&thu='.$i . '&tiet='.$j;
                    $xtpl->assign('DISPLAY_ADD', 'block');
                    $xtpl->assign('DISPLAY_EDIT', 'none');
                    $xtpl->assign('DISPLAY_IMG', 'none');
    
                }

                $xtpl->assign('DATA', $value);
                $xtpl->assign('DAY', $day);
                $xtpl->assign('LESSON', $j);
                
                $xtpl->parse('manageheadbook.loopday.looplesson');
            }
    
    
        } else {
            // die($i . ' kkk');
            for ($j=1; $j <= 5; $j++) {
                $day = '';
                $value = [];
                if ($j== 1) {
                    // $dayspecifed = nv_date('d/m/Y', $value['ngaysinh']);
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
                }
                $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&manamhoc='.$manamhoc_get.'&matuan='.$matuan_get.'&malop='.$malop_get.'&mabuoi='.$mabuoi_get.'&thu='.$i . '&tiet='.$j;
    
                $xtpl->assign('DATA', $value);
                $xtpl->assign('DAY', $day);
                $xtpl->assign('LESSON', $j);
                $xtpl->assign('DISPLAY_ADD', 'block');
                $xtpl->assign('DISPLAY_IMG', 'none');
                $xtpl->assign('DISPLAY_EDIT', 'none');

                $xtpl->parse('manageheadbook.loopday.looplesson');
            }
        }
        $xtpl->parse('manageheadbook.loopday');
        $currenttime += 86400;
    }
    $display_form = '';
}



$xtpl->assign('DISPLAY_FORM', $display_form);

$xtpl->parse('manageheadbook');
$contents = $xtpl->text('manageheadbook');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
