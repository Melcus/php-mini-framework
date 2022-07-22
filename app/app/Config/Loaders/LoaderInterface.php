<?php

declare(strict_types=1);

namespace App\Config\Loaders;

interface LoaderInterface
{
    public function parse(): array;
}
