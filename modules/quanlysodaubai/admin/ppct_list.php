<?php

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

include dirname(__FILE__) . '/../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';

$page_title = $lang_module['ppct_list'];
$error = '';
$success = '';

$action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

// Hiển thị
$xtpl = new XTemplate('ppct_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('FORM_ACTION', $action);

// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct');

// Đổ dữ liệu
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}

// hien thi du lieu 
if($array) { 
    $i = 1;
    foreach ($array as $value) {
        $value['stt'] = $i++;
        $xtpl->assign('DATA', $value);
        $xtpl->parse('main.loop');
    }
}

// Subject
$querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist');
$i = 0;
$selectedsubject;
while ($row = $querysubject->fetch()) {
	$arraysubject[$row['mamonhoc']] = $row;
	if($i ==0)
	{
		$selectedsubject = $row['mamonhoc'];
	}
	$i++;
}

// hien thi du lieu subject drop down
if(!empty($arraysubject)) { 
	foreach ($arraysubject as $value) {
		$value['key'] = $value['mamonhoc'];
		$value['title'] = $value['tenmonhoc'];
		$value['selected'] = $selectedsubject == $value['mamonhoc'] ? "selected" : "";

		$xtpl->assign('DATA_SUBJECT', $value);
		$xtpl->parse('main.loopsubject');
	}
}

$selectedkhoi = $lang_module['khoi1'];
for ($i = 1; $i <= 12; ++$i) {
	$value = [
		'key' => $i,
		'title' => $lang_module['khoi' . $i],
		'selected' => $selectedkhoi == $lang_module['khoi' . $i] ? ' selected="selected"' : ''
	];
	$xtpl->assign('DATA_KHOI', $value);
	$xtpl->parse('main.loopkhoi');
}

$selectednamhoc = $lang_module['namhoc1'];
for ($i = 1; $i <= 3; ++$i) {
	$value = [
		'key' => $i,
		'title' => $lang_module['namhoc' . $i],
		'selected' => $selectednamhoc == $lang_module['namhoc' . $i] ? ' selected="selected"' : ''
	];
	$xtpl->assign('DATA_NAMHOC', $value);
	$xtpl->parse('main.loopnamhoc');
}

// Khi nhấp Import
if ($nv_Request->isset_request('do', 'post')) {
	if (isset($_FILES['ufile']) && is_uploaded_file($_FILES['ufile']['tmp_name'])) {
		$filename = nv_string_to_filename($_FILES['ufile']['name']);
        $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename;
        if(file_exists($file)){
            unlink($file);
        }
        if (move_uploaded_file($_FILES['ufile']['tmp_name'], $file)) {
			if (file_exists($file)) {
	            try {
	                $fileType = PHPExcel_IOFactory::identify($file);
	                $objReader = PHPExcel_IOFactory::createReader($fileType);
	                $objPHPExcel = $objReader->load($file);
	            } catch(Exception $e) {
	                $error = $lang_module['error_cannot_read_file'].' '.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage();
	            }

	            if (empty($error)) {
	            	$sheet = $objPHPExcel->getSheet(0); 
		            $highestRow = $sheet->getHighestRow();
		            $highestColumn = $sheet->getHighestColumn();
					
					for ($row = 1; $row <= $highestRow; $row++){
		            	$dataRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		            	if($row <= 3) 
							$info[] = $dataRow;
						else if ($row >= 6)	
		                	$data[] = $dataRow;
		            }

					$namhoc = $info[0][0][1];
					$khoi = $info[1][0][1];
					$tenmonhoc = $info[2][0][1];

					// $namhoc = nv_substr($nv_Request->get_title('namhoc', 'post', ''), 0, 250);
					// $khoi = nv_substr($nv_Request->get_title('khoi', 'post', ''), 0, 250);				
					// $tenmonhoc = nv_substr($nv_Request->get_title('monhoc', 'post', ''), 0, 250);
					
					// for ($i = 1; $i <= 3; ++$i) {
					// 	$namhoc = nv_substr($nv_Request->get_title('namhoc_' . $i, 'post', ''), 0, 250);
					// }
					// $namhoc = $lang_module['namhoc' . $namhoc];
					// foreach ($subjectarray as $value) {
					// 	$row['gvcn'] = $nv_Request->get_int('namhoc_' . $value['userid'], 'post', '');
					// }

					// for ($i = 1; $i <= 12; ++$i) {
					// 	$khoi = nv_substr($nv_Request->get_title('khoi_' . $i, 'post', ''), 0, 250);
					// }

					// if(!empty($arraysubject)) { 
					// 	foreach ($arraysubject as $value) {
					// 		$tenmonhoc = $nv_Request->get_int('_' . $value['subjectid'], 'post', '');
					// 	}
					// }
		            // Bắt đầu import vào database
					$db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_ppct");					
					for($i = 0; $i <= $highestRow - 6; $i++) {
						$tiet = $data[$i][0][0];
						$tenbaihoc = $data[$i][0][1];	
						$_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_ppct
							(namHoc, khoi, tenMonHoc, tiet, tenBaiHoc) VALUES
							(:namhoc, :khoi, :tenmonhoc, :tiet, :tenbaihoc)';						
						$sth = $db->prepare($_sql);
						$sth->bindParam(':namhoc', $namhoc, PDO::PARAM_STR);
						$sth->bindParam(':khoi', $khoi, PDO::PARAM_INT);
						$sth->bindParam(':tenmonhoc', $tenmonhoc, PDO::PARAM_INT);
						$sth->bindParam(':tiet', $tiet, PDO::PARAM_INT);
						$sth->bindParam(':tenbaihoc', $tenbaihoc, PDO::PARAM_INT);
						$sth->execute();
					}	
					$success = $lang_module['import_success'];
					unlink($file);
	            }
	        } else {
	        	$error = $lang_module['error_upload_file'];
	        }
		} else {
        	$error = $lang_module['error_upload_file'];
        }
	} else {
		$error = $lang_module['error_dont_have_file'];
	}
}

if ($error) {
	$xtpl->assign('ERROR', $error);
	$xtpl->parse('main.error');
}

if ($success) {
	$xtpl->assign('SUCCESS', $success);
	$xtpl->parse('main.success');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
 
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");