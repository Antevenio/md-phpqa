<?php

namespace MD\PHPQA;

class Installer
{
    public static function postInstall()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cmd /c vendor\md\md-phpqa\src\setup.bat');
        }
        else {
            system('sh vendor/md/md-phpqa/src/setup.sh');
        }
    }
}