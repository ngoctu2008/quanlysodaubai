<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

if (!defined('NV_IS_AJAX')) {
    exit('Wrong URL');
}

die("Vao del r ne");

$checkss = $nv_Request->get_string('checkss', 'post');
$malop = $nv_Request->get_int('malop', 'post', 0);
$contents = '';

if ($malop > 0 and $checkss == md5($malop . NV_CHECK_SESSION)) {
    $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_classlist WHERE maLop = ' . $malop;
    if ($db->exec($sql)) {

        $contents = $lang_module['delete_success'];
    } else {
        $contents = $lang_module['delete_unsuccess'];
    }
}


include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';
