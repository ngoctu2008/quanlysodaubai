<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

if (! defined('NV_IS_AJAX')) {
    die('Wrong URL');
}

$checkss = $nv_Request->get_string('checkss', 'post');
$manamhoc = $nv_Request->get_int('manamhoc', 'post', 0);
$contents = '';

if ($manamhoc > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_delclass', "malop " . $manamhoc, $admin_info['userid']);
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_schoolyear WHERE manamhoc=' . $manamhoc;
    if ($db->exec($sql)) {
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_schoolyear WHERE manamhoc=" . $manamhoc);
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_week WHERE manamhoc=" . $manamhoc);
        $nv_Cache->delMod($module_name);

        $contents = "OK_" . $manamhoc;
    } else {
        $contents = "ERR_" . $lang_module['class_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
