<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2022 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 30 Nov 2022 02:45:36 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$array_except_flood_site = [];
$array_except_flood_site['::1'] = ['ip6' => 1, 'mask' => "::1/0", 'begintime' => 1669776336, 'endtime' => 0];

$array_except_flood_admin = [];
