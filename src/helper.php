<?php
/**
 * Desc:
 * Created by PhpStorm.
 * User: jason-gao
 * Date: 2018/2/11 14:55
 */

/**
 * @return bool Whether the host machine is running a Windows OS
 */
function isWindows()
{
    return defined('PHP_WINDOWS_VERSION_BUILD');
}