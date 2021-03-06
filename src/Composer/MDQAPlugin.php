<?php

namespace MD\PHPQA\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class MDQAPlugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'runIntegration',
            ScriptEvents::POST_UPDATE_CMD => 'runIntegration'
        ];
    }

    public function runIntegration(Event $event)
    {
        if (class_exists(DevelopmentIntegrator::class)) {
            DevelopmentIntegrator::integrate($event);
        }
    }
}
