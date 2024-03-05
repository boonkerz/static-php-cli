<?php

declare(strict_types=1);

namespace SPC\builder\extension;

use SPC\builder\Extension;
use SPC\exception\RuntimeException;
use SPC\store\FileSystem;
use SPC\util\CustomExt;

#[CustomExt('pthreads')]
class pthreads extends Extension
{
    /**
     * @throws RuntimeException
     */
    public function patchBeforeBuildconf(): bool
    {
        if (file_exists(SOURCE_PATH . DIRECTORY_SEPARATOR . 'php-src' . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'pthreads')) {
            return false;
        }
        FileSystem::copyDir(SOURCE_PATH . DIRECTORY_SEPARATOR . 'ext-pthreads', SOURCE_PATH . DIRECTORY_SEPARATOR . 'php-src' . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'pthreads');
        return true;
    }

    public function patchBeforeConfigure(): bool
    {
       // FileSystem::replaceFileStr(SOURCE_PATH . '/php-src/configure', '-lglfw ', '-lglfw3 ');
        return true;
    }

    public function getUnixConfigureArg(): string
    {
        return '';
    }

    public function getWindowsConfigureArg(): string
    {
        return '--enable-pthreads';
    }
}
