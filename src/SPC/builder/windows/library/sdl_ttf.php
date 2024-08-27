<?php

declare(strict_types=1);

namespace SPC\builder\windows\library;

use SPC\store\FileSystem;

class sdl_ttf extends WindowsLibraryBase
{
    public const NAME = 'sdl_ttf';

    protected function build(): void
    {
        // reset cmake
        FileSystem::resetDir($this->source_dir . DIRECTORY_SEPARATOR . 'build');

        // start build
        cmd()->cd($this->source_dir)
            ->execWithWrapper(
                $this->builder->makeSimpleWrapper('cmake'),
                '-B build ' .
                '-A x64 ' .
                '-DCMAKE_BUILD_TYPE=Release ' .
                // '-DSDL_DISABLE_INSTALL=1 '.
                '-DSDL_DISABLE_INSTALL_DOCS=1 ' .
                '-DSDL_TEST_LIBRARY=0 ' .
                '-DBUILD_SHARED_LIBS=OFF ' .
                '-DCMAKE_INSTALL_PREFIX=' . BUILD_ROOT_PATH . ' '
            )
            ->execWithWrapper(
                $this->builder->makeSimpleWrapper('cmake'),
                '--build build --config Release --target install ' .
                "-j{$this->builder->concurrency}"
            );
    }
}
