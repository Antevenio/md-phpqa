<?php

namespace MD\PHPQA\Composer;

use Composer\Script\Event;

class DevelopmentIntegrator
{
    const CONFIG_DIR = 'config';

    protected static function getThisProjectRootDirectory()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "..";
    }

    protected static function getThisProjectConfigDirectory()
    {
        return static::getThisProjectRootDirectory() . DIRECTORY_SEPARATOR . self::CONFIG_DIR;
    }

    protected static function getProjectRootDirectory()
    {
        return getcwd();
    }

    protected static function getInProjectPathnameForFile($filename)
    {
        return static::getProjectRootDirectory() . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * @param Event $event
     */
    public static function integrate(Event $event)
    {
        $directoryIterator = new \DirectoryIterator(static::getThisProjectConfigDirectory());
        foreach ($directoryIterator as $file)
        {
            if ($file->isFile()) {
                $inProjectPathname = static::getInProjectPathnameForFile($file->getFilename());
                if (!file_exists($inProjectPathname)) {
                    copy($file->getPathname(), $inProjectPathname);
                    $event->getIO()->write(
                        '<fg=green>' .
                        '[PHPQA] Copied default configuration file: '.$file->getFilename() .
                        '</fg=green>'
                    );
                }
            }
        }
    }
}