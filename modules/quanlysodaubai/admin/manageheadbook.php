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

$page_title = $lang_module['manage_headbook'];

$xtpl = new XTemplate('manageheadbook.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);



for ($i=2; $i <= 8; $i++){
    // die("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE matuan=1 AND malop=1 AND mabuoi=1 AND thu LIKE 'Th%". $i ."' ORDER BY tiet ASC");

    $array = [];

    // Gọi csdl để lấy dữ liệu
    
    $query = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE matuan=1 AND malop=1 AND mabuoi=1 AND thu LIKE 'Th%". $i ."' ORDER BY tiet ASC");
    // đổ dữ liệu 
    while ($row = $query->fetch()) {
        $array[$row['tiet']] = $row;
    }


    if ($array) {
        for ($j = 1; $j <= 5; $j++) {
            $value = $array[$j];
            $day = '';
            if ($j == 1) {
                $day = '<td rowspan="5" align="center" style="vertical-align:middle">'. $lang_module['day'.$i] .'</td>';
            }
            if ($value) {
                $value['checksess'] = md5($value['masodaubai'] . NV_CHECK_SESSION);

                $value['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&matuan=' . $value['matuan'] . '&malop='.$value['malop']. '&mabuoi='.$value['mabuoi']. '&thu='.$i . '&tiet='.$value['tiet'] . '&id='.$value['masodaubai'];

                $xtpl->assign('DISPLAY_ADD', 'none');
                $xtpl->assign('DISPLAY_EDIT', 'block');

                $xtpl->assign('DISPLAY_ADD', 'none');
                $xtpl->assign('DISPLAY_EDIT', 'block');
                $xtpl->assign('DISPLAY_IMG', 'block');
            } else {
                $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&matuan=1&malop=1&mabuoi=1&thu='.$i . '&tiet='.$j;
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
                $day = '<td rowspan="5" align="center" style="vertical-align:middle">'. $lang_module['day'.$i] .'</td>';
            }
            $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&matuan=1&malop=1&mabuoi=1&thu='.$i . '&tiet='.$j;

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
}

$xtpl->parse('manageheadbook');
$contents = $xtpl->text('manageheadbook');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
