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

$page_title = $lang_module['teacherlist'];


$xtpl = new XTemplate('teacherlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

for ($i=0; $i < 4; $i++) { 
    $xtpl->assign('DAY', $i);
    for ($j=0; $j < 4; $j++) { 
        $xtpl->assign('LESSON', $j);
        $xtpl->parse('teacherlist.loopday.looplesson');
    }
    $xtpl->parse('teacherlist.loopday');
}

$xtpl->parse('teacherlist');
$contents = $xtpl->text('teacherlist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
