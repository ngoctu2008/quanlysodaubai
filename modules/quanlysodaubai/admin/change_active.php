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

$matuan = $nv_Request->get_int('matuan', 'post', 0);


$new_status = $nv_Request->get_bool('new_status', 'post');
$new_status = (int) $new_status;

$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_week SET trangthai=' . $new_status . ' WHERE matuan=' . $matuan;
$db->query($sql);


include NV_ROOTDIR . '/includes/header.php';
echo 'OK_' . $matuan;
include NV_ROOTDIR . '/includes/footer.php';
