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

// hien thi du lieu hocsinh
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

// hien thi du lieu hocsinh
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

    // hien thi du lieu hocsinh
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
// cho nay lay trang thai tuan do



if($manamhoc_get > 0 && $malop_get > 0 && $mabuoi_get >0 && $matuan_get >0) {
    if($datatungay['trangthai'] == 1) {
        $xtpl->assign('DISPLAY_INFO', 'style="display:none"');
        $xtpl->assign('DISPLAY_FUNC_TITLE', '');
        $xtpl->assign('DISPLAY_FUNC', '');
    } else {
        $xtpl->assign('DISPLAY_INFO', '');
        $xtpl->assign('DISPLAY_FUNC_TITLE', 'display:none;');
        $xtpl->assign('DISPLAY_FUNC', 'style="display:none;"');
    }
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
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle; font-weight:600">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
                }
                if ($value) {
                    $value['checksess'] = md5($value['masodaubai'] . NV_CHECK_SESSION);
                    $value['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&manamhoc='.$manamhoc_get.'&matuan=' . $matuan_get . '&malop='.$malop_get. '&mabuoi='.$mabuoi_get. '&thu='.$i . '&tiet='.$value['tiet'] . '&id='.$value['masodaubai'];
    
                    // lay ra mon hoc
                    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist WHERE maMonHoc=' . $value['mamon']);
                    $datasubject = $querysubject->fetch();
                    $value['tenmonhoc'] = $datasubject['tenmonhoc'];
    
                    // chuyen thanh array
                    $arrabsent1 = explode(",", $value['cophep']);
                    $arrabsent2 = explode(",", $value['khongphep']);
                    $value['tenhocsinhnghi'] = '';
                    // lay ra may thang nghi
                    if ($arrabsent1[0]  != 0) {
                        $last_key1 = end(array_keys($arrabsent1));
                        foreach ($arrabsent1 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key1) {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ': CP';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ', ';
                            }
                        }
                    }
                    
                    if ($arrabsent2[0]  != '') {
                        if ($arrabsent1[0] != '')
                            $value['tenhocsinhnghi'] .= ', ';
                        $last_key2 = end(array_keys($arrabsent2));
                        foreach ($arrabsent2 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key2) {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ': K';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ', ';
                            }
                        }
                    }
                    
                    
                    // lay di may thang di hoc mon 

                    $arrlate = explode(",", $value['dimuon']);
                    $value['tenhocsinhdimuon'] = '';
                    if($arrlate[0] != '') {
                        $last_key3 = end(array_keys($arrlate));
                        foreach ($arrlate as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $querylate = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $datalate = $querylate->fetch();
                            if ($key == $last_key3) {
                                $value['tenhocsinhdimuon'] .= $datalate['hoten'];
                            } else {
                                $value['tenhocsinhdimuon'] .= $datalate['hoten'] . ', ';
                            }
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
            for ($j=1; $j <= 5; $j++) {
                $day = '';
                $value = [];
                if ($j== 1) {
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle;font-weight:600">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
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
else {
    $xtpl->assign('DISPLAY_INFO', 'style="display:none"');
}

//Export Excel
if ($nv_Request->isset_request('export', 'post')) {
    include dirname(__FILE__) . '/../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';
    $objPHPExcel = new PHPExcel();   
    $objPHPExcel->getProperties()
                ->setCreator("Administrator")
                ->setTitle("Sổ đầu bài");
    $objPHPExcel->createSheet(NULL, 1);

    $objPHPExcel->setActiveSheetIndex(1);   
    $r = 2;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$r, 'Thứ, ngày');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$r, 'Tiết');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$r, 'Môn');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$r, 'Tiết PPCT');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$r, 'Tên bài học, nội dung công việc');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$r, 'Học sinh vắng');
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$r, 'Đi học muộn');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$r, 'Nhận xét');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$r, 'Điểm');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.($r+1), 'Học tập');
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.($r+1), 'Kỷ luật');
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.($r+1), 'Vệ sinh');
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$r, 'Tổng điểm');
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$r, 'GV dạy kí tên');
    $rowCount = $r+2;

    //Merge Cells
    $objPHPExcel->getActiveSheet()->mergeCells('A'.($r-1).':M'.($r-1));
    $objPHPExcel->getActiveSheet()->mergeCells('I'.$r.':K'.$r);
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$r.':A'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('B'.$r.':B'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('C'.$r.':C'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('D'.$r.':D'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('E'.$r.':E'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('F'.$r.':F'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('G'.$r.':G'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('H'.$r.':H'.($r+1));
    $objPHPExcel->getActiveSheet()->mergeCells('L'.$r.':L'.($r+1));    
    $objPHPExcel->getActiveSheet()->mergeCells('M'.$r.':M'.($r+1));    
    $begin = $rowCount;
    while ($begin+1<=38){  
        $end = $begin + 4;
        $objPHPExcel->getActiveSheet()->mergeCells('A'. $begin .':A' . $end);
        $begin = $end + 1;
    }    

    //Set Style
    $objPHPExcel->getActiveSheet()->getStyle("A".$r.":O".$r)->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("I".($r+1).":K".($r+1))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle("A".($r-1).":M".($r+36))->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle("A".($r-1).":M".($r+36))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+36))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("E".($r+3).":H".($r+36))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle("O".$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("O".$r.":O".($r+36))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(45);
    // $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
    $outline = array(
        'borders' => array(
            'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK
            )
        )
    );
    $horizontal = array(
        'borders' => array(
            'horizontal' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED  
            )
        )
    );
    $vertical = array(
        'borders' => array(
            'vertical' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK 
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+36))->applyFromArray($horizontal);
    $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+36))->applyFromArray($vertical);
    $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+1))->applyFromArray($outline);
    $objPHPExcel->getActiveSheet()->getStyle("I".$r.":K".$r)->applyFromArray($outline);
    $begin = $rowCount;
    while ($begin+1<=38){  
        $end = $begin + 4;
        $objPHPExcel->getActiveSheet()->getStyle('A'. $begin .':M' . $end)->applyFromArray($outline);
        $begin = $end + 1;
    }
    unset($styleArray);
    
    //Tổng kết tuần
    $tuan_vang = '...';
    $tuan_vang_P = '...';
    $tuan_vang_K = '...';
    $tuan_muon = '...';
    $tuan_vpkhac = '...';
    $tuan_diem_hoctap = '...';
    $tuan_diem_kyluat = '...';
    $tuan_diem_vesinh = '...';
    $tuan_diem_tru= '...';
    $tuan_diem_tb = '...';
    $tuan_hoctot = '...';
    $tuan_xepthu = '...';
    $tuan_YK_GVBM = '...';
    $tuan_YK_GVCN = '...';
    $tuan_YK_BGH = '...';
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$r, mb_strtoupper('Tổng kết tuần'));
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+1), 'Vắng: '.$tuan_vang.', trong đó: '.$tuan_vang_P.'P; '.$tuan_vang_K.'K');
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+2), 'Đi học muộn: '.$tuan_muon);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+3), 'Vi phạm khác: '.$tuan_vpkhac);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+5), 'Điểm cuối tuần: ');
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+6), 'Học tập: '.$tuan_diem_hoctap);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+7), 'Kỷ luật: '.$tuan_diem_kyluat);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+8), 'Vệ sinh: '.$tuan_diem_vesinh);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+9), 'Điểm trừ: '.$tuan_diem_tru);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+10), 'Điểm TB của tuần: '.$tuan_diem_tb);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+11), 'Đạt tuần học tốt: '.$tuan_hoctot);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+12), 'Xếp thứ: '.$tuan_xepthu);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+14), 'Kiến nghị của GVBM:');
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+15), $tuan_YK_GVBM);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+17), 'Ý kiến GVCN:');    
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+18), $tuan_YK_GVCN);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+20), 'Nhận xét của BGH:');    
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.($r+21), $tuan_YK_BGH);
    $objPHPExcel->getActiveSheet()->getStyle('O'.($r+14))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('O'.($r+17))->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('O'.($r+20))->getFont()->setBold(true);

    //Đổ dữ liệu vào file excel
    
    if($manamhoc_get > 0 && $malop_get > 0 && $mabuoi_get >0 && $matuan_get >0){
        //Lấy dữ liệu
        $query_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_setupinfo');
        $data_info = $query_info->fetch(); 

        if($manamhoc_get) {
            $query_schoolyear = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_schoolyear WHERE manamhoc=". $manamhoc_get);              
            $data_schoolyear = $query_schoolyear->fetch();
            $namhoc_get = $data_schoolyear['tunam'] . ' - ' . $data_schoolyear['dennam'];
            $namhoc_get_short = $data_schoolyear['tunam'] . '-' . $data_schoolyear['dennam'];
        }
 
        if($matuan_get) {
            $query_week = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_week WHERE matuan=". $matuan_get);              
            $data_week = $query_week->fetch();
            $tuan_get = $data_week['tentuan'];
            $tuan_get_short = "Tuan" . substr($tuan_get, 7);
        }
        
        if($malop_get){
            $query_class = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_classlist WHERE maLop=". $malop_get);              
            $data_class = $query_class->fetch();
            $class_get = $data_class['tenlop'];   
            
            $query_teacher = $db->query('SELECT * FROM nv4_users WHERE userid = ' . $data_class['magvcn']);
            $data_teacher = $query_teacher->fetch();
            $teacher_get = $data_teacher['first_name'] . ' ' . $data_teacher['last_name'];
        }

        if($mabuoi_get) {
            $buoi_get = $lang_module['daystatus'.$mabuoi_get];      
            $buoi_get_short = ($mabuoi_get == 1) ? "Sang" : "Chieu";
        }      

        //Đặt tên file
        $filename = "SoDauBai_" . $class_get . "_" . $tuan_get_short . "_". $namhoc_get_short . "_" . $buoi_get_short . ".xlsx";
        $title = $data_week['tentuan'].' (từ ngày '.nv_date('d/m/Y', $data_week['tungay']). ' đến ngày '.nv_date('d/m/Y', $data_week['denngay']) .')';
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r-1), $title);
        $objPHPExcel->getProperties()->setTitle("Sổ đầu bài ".$title);
        $objPHPExcel->getActiveSheet()->setTitle($tuan_get);   

        //Bìa sổ đầu bài
        $objPHPExcel->setActiveSheetIndex(0);   
        $objPHPExcel->getActiveSheet()->setTitle('Bìa');    
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+1), (string)$data_info['tenso']);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+2), (string)$data_info['phong']);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+3), (string)$data_info['truong']);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+14), 'SỔ ĐẦU BÀI');
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+19), 'Lớp: ' . $class_get);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+20), 'GVCN: ' . $teacher_get);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.($r+35), 'Năm học: ' . $data_info['tunam'] .' - ' . $data_info['dennam']);

        $objPHPExcel->getActiveSheet()->getStyle("A".$r.":G".($r+36))->applyFromArray($outline);
        $objPHPExcel->getActiveSheet()->getStyle("H".$r.":O".($r+36))->applyFromArray($outline);
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+1).':G'.($r+1));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+2).':G'.($r+2));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+3).':G'.($r+3));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+14).':G'.($r+18));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+19).':G'.($r+19));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+20).':G'.($r+20));
        $objPHPExcel->getActiveSheet()->mergeCells('A'.($r+35).':G'.($r+35));

        $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+36))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("A".$r.":M".($r+36))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+3))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+14))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+1))->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+2))->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+3))->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+14))->getFont()->setSize(40);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+19))->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+20))->getFont()->setItalic(true);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+20))->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A'.($r+35))->getFont()->setSize(16);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(45);
        $objPHPExcel->setActiveSheetIndex(1);   
        
        //Đổ dữ liệu vào các ô
        $currenttime = $datatungay['tungay'];
        for ($i=2; $i <= 8; $i++){  
            $day = $lang_module['day'.$i]. "\n" .nv_date('d/m/Y',$currenttime);    
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $day);
            $array = [];
            $query = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE matuan=".$matuan_get." AND malop=".$malop_get." AND mabuoi=".$mabuoi_get." AND thu LIKE 'Th%". $i ."' ORDER BY tiet ASC");
            while ($row = $query->fetch()) {
                $array[$row['tiet']] = $row;
            }             
            for ($j = 1; $j <= 5; $j++) {
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $j);
                if ($array) {
                    $value = $array[$j];
                    // die(json_encode($value));
                    $mamon = $value["mamon"];
                    $tietppct = $value["tietppct"];
                    $hocsinhvang = $value["hocsinhvang"];
                    $tenbaihoc = $value["tenbaihoc"];
                    $nhanxet = $value["nhanxet"];
                    $diemhoctap = $value["diemhoctap"];
                    $diemkyluat = $value["diemkyluat"];
                    $diemvesinh = $value["diemvesinh"];
                    $tongdiem = $value["tongdiem"];

                    // lay ra mon hoc
                    if($value["mamon"]) {
                        $querysubject = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_subjectlist WHERE maMonHoc=". $value["mamon"]);              
                        $datasubject = $querysubject->fetch();
                        $value["tenmonhoc"] = $datasubject['tenmonhoc'];
                    }

                    // chuyen thanh array
                    $arrabsent1 = explode(",", $value['cophep']);
                    $arrabsent2 = explode(",", $value['khongphep']);
                    $value['tenhocsinhnghi'] = '';
                    // lay ra may thang nghi
                    if ($arrabsent1[0]  != 0) {
                        $last_key1 = end(array_keys($arrabsent1));
                        foreach ($arrabsent1 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key1) {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ': CP';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ', ';
                            }
                        }
                    }
                    
                    if ($arrabsent2[0]  != '') {
                        if ($arrabsent1[0] != '')
                            $value['tenhocsinhnghi'] .= ', ';
                        $last_key2 = end(array_keys($arrabsent2));
                        foreach ($arrabsent2 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key2) {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ': K';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['hoten'] . ', ';
                            }
                        }
                    }
                     
 
                     $arrlate = explode(",", $value['dimuon']);
                     $value['tenhocsinhdimuon'] = '';
                     if($arrlate[0] != '') {
                         $last_key3 = end(array_keys($arrlate));
                         foreach ($arrlate as $key => $mahocsinh) {
                             // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                             $querylate = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                             $datalate = $querylate->fetch();
                             if ($key == $last_key3) {
                                 $value['tenhocsinhdimuon'] .= $datalate['hoten'];
                             } else {
                                 $value['tenhocsinhdimuon'] .= $datalate['hoten'] . ', ';
                             }
                         }
                     }
                    
                    $signed = $value["giaovienbmkiten"]?"Đã ký":"";       
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value["tenmonhoc"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $tietppct);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $tenbaihoc);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['tenhocsinhnghi']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['tenhocsinhdimuon']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $nhanxet);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $diemhoctap);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $diemkyluat);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $diemvesinh);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $tongdiem);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $signed); 
                }  
                ++$rowCount; 
            } 
            $currenttime += 86400;
        }
        $objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename='. $filename); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        ob_start();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
        $objWriter->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();
        die($content);
    }
}

$xtpl->assign('DISPLAY_FORM', $display_form);

$xtpl->parse('manageheadbook');
$contents = $xtpl->text('manageheadbook');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
