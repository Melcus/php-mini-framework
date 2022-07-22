<?php

declare(strict_types=1);

namespace App\Config\Loaders;

class ArrayLoader implements LoaderInterface
{
    public function __construct(protected array $files) {}

    public function parse(): array
    {
        $parsed = [];

        foreach ($this->files as $namespace => $path) {
            $parsed[$namespace] = require $path;
        }

        return $parsed;
    }
}
