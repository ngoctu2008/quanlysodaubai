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
$masodaubai = $nv_Request->get_int('masodaubai', 'post', 0);
$contents = '';

if ($masodaubai > 0) {
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_headbook WHERE masodaubai=' . $masodaubai;
    if ($db->exec($sql)) {
        $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE masodaubai=" . $masodaubai);
        $nv_Cache->delMod($module_name);

        $contents = "OK_" . $masodaubai;
    } else {
        $contents = "ERR_" . $lang_module['class_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
