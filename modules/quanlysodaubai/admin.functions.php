<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 2:29
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

$allow_func = array(
    'main',
    'setupinfo',
    'classlist',
    'studentlist',
    'subjectlist',
    'teacherlist',
    'addstudent',
    'addclass',   
    'addsubject',
    'delstudent',
    'delclass',
    'delsubject',
    'del'
);

define('NV_IS_FILE_ADMIN', true);

// if (defined('NV_IS_SPADMIN')) {
// 	$allow_func[] = 'config';
// }