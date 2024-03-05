<?php

declare(strict_types=1);

namespace SPC\builder\windows\library;

use SPC\store\FileSystem;
use SPC\store\SourcePatcher;

class pthreadwin32 extends WindowsLibraryBase
{
    public const NAME = 'pthreadwin32';

    public function patchBeforeBuild(): bool
    {
        SourcePatcher::patchFile('0001_pthread_w32.patch', $this->source_dir);
        return true;
    }

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
