# Universal PHPCS git pre-commit hook 

## About

Auto installed git pre-commit hook for running [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer)
code checking to PSR2 coding standard compliance. It checks only files that are to be committed.

Inspired by [Enforce code standards with composer, git hooks, and phpcs](http://tech.zumba.com/2014/04/14/control-code-quality/) and https://github.com/smgladkovskiy/phpcs-git-pre-commit and https://gist.github.com/BrizzleRocker/62ed61b37acf05344d4bce894e719251 . Installer checks OS on hosting machine and installs needed hooks for platform.

## Installation

Install `md/md-phpqa` with composer require command:

    composer require "md/md-phpqa"

Or alternatively, include a dependency for `md/md-phpqa` in your composer.json file manually:

    {
        "require-dev": {
            "md/md-phpqa": "*"
        }
    }

To enable code sniff, аdd to `post-install-cmd` and `post-update-cmd` in `composer.json` installation script:

    "scripts": {
        "post-install-cmd": [
            "MDPHPQA\\Installer::postInstall"
        ],
        "post-update-cmd": [
            "MDPHPQA\\Installer::postInstall"
        ]
    }

Then run `composer install` or `composer update`. `pre-commit` hook will be installed or updated if it already exists.

## Usage

Run `git commit` and pre-commit hook will check your committed files like if you run

    php phpcs.phar --standard=PSR2 --colors --encoding=utf-8 -n -p /path/to/file.php
