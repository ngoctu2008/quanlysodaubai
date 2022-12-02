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
$subjectid = $nv_Request->get_int('subjectid', 'post', 0);
$contents = '';

if ($subjectid > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_delsubject', "mamonhoc " . $subjectid, $admin_info['userid']);
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subjectlist WHERE maMonHoc=' . $subjectid;
    if ($db->exec($sql)) {
        $contents = "OK_" . $subjectid;
    } else {
        $contents = "ERR_" . $lang_module['subject_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
