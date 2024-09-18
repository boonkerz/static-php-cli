<?php

declare(strict_types=1);

namespace SPC\builder\linux\library;

class sdl extends LinuxLibraryBase
{
    use \SPC\builder\unix\library\sdl;

    public const NAME = 'sdl';
}
