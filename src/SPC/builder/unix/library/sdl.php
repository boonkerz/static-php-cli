<?php

declare(strict_types=1);

namespace SPC\builder\unix\library;

use SPC\exception\FileSystemException;
use SPC\exception\RuntimeException;
use SPC\exception\WrongUsageException;
use SPC\store\FileSystem;

trait sdl
{
    /**
     * @throws RuntimeException
     * @throws FileSystemException
     */
    protected function build(): void
    {
        FileSystem::resetDir($this->source_dir . '/build');

        shell()->cd($this->source_dir . '/build')
        ->exec(
            'cmake ' .
            "{$this->builder->makeCmakeArgs()} " .
            //'-DCMAKE_INSTALL_PREFIX=' . BUILD_ROOT_PATH . ' ' .
            '-DCMAKE_BUILD_TYPE=Release ' .
            '-DSDL_DISABLE_INSTALL_DOCS=1 ' .
            '-DSDL_TEST_LIBRARY=0 ' .
            '-DSDL_STATIC=1 ' .
            '-DSDL_SHARED=0 ' .
            '..'
        )
        ->exec("cmake --build . -j {$this->builder->concurrency}")
        ->exec('make install DESTDIR=' . BUILD_ROOT_PATH);
    }
}
