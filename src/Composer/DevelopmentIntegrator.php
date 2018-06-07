<?php

namespace MD\PHPQA\Composer;

use Composer\Script\Event;
use GrumPHP\Locator\ConfigurationFile;
use Symfony\Component\Yaml\Yaml;

class DevelopmentIntegrator
{

    const CONFIG_DIR = 'config';

    const DEFAULT_YAML = [
        'parameters' => [
            'git_dir' => '.',
            'bin_dir' => 'vendor/bin',
            'tasks' => null
        ]
    ];

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

    protected static function isDefaultGrumPHPYamlFile($filename)
    {
        return Yaml::parse($filename) == static::DEFAULT_YAML;
    }

    /**
     * @param Event $event
     */
    public static function integrate(Event $event)
    {
        $event->getIO()->write(
            '<fg=green>' .
            '[PHPQA] Integrating!' .
            '</fg=green>'
        );
        $directoryIterator = new \DirectoryIterator(static::getThisProjectConfigDirectory());
        foreach ($directoryIterator as $file) {
            if ($file->isFile()) {
                $filename = $file->getFilename();
                $inProjectPathname = static::getInProjectPathnameForFile($filename);
                if (!file_exists($inProjectPathname)) {
                    copy($file->getPathname(), $inProjectPathname);
                    $event->getIO()->write(
                        '<fg=green>' .
                        '[PHPQA] Copied default configuration file: ' . $filename .
                        '</fg=green>'
                    );
                } else {
                    if ($filename == ConfigurationFile::APP_CONFIG_FILE &&
                        static::isDefaultGrumPHPYamlFile($inProjectPathname)) {
                        $event->getIO()->write(
                            '<fg=green>' .
                            '[PHPQA] Overwrite default ' . $filename .
                            '</fg=green>'
                        );
                        copy($file->getPathname(), $inProjectPathname);
                    }
                }
            }
        }
    }
}
