<?php

declare(strict_types=1);

namespace SPC\builder\extension;

use SPC\builder\Extension;
use SPC\exception\RuntimeException;
use SPC\store\FileSystem;
use SPC\util\CustomExt;

#[CustomExt('parallel')]
class parallel extends Extension
{
    /**
     * @throws RuntimeException
     */
    public function patchBeforeBuildconf(): bool
    {
        if (file_exists(SOURCE_PATH . DIRECTORY_SEPARATOR . 'php-src' . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'parallel')) {
            return false;
        }
        FileSystem::copyDir(SOURCE_PATH . DIRECTORY_SEPARATOR . 'ext-parallel', SOURCE_PATH . DIRECTORY_SEPARATOR . 'php-src' . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'parallel');
        return true;
    }

    public function patchBeforeConfigure(): bool
    {
       // FileSystem::replaceFileStr(SOURCE_PATH . '/php-src/configure', '-lglfw ', '-lglfw3 ');
        return true;
    }

    public function getUnixConfigureArg(): string
    {
        return '--with-parallel';
    }

    public function getWindowsConfigureArg(): string
    {
        return '--with-parallel';
    }
}
