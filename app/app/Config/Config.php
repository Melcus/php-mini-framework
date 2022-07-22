<?php

declare(strict_types=1);

namespace App\Config;

use App\Config\Loaders\LoaderInterface;

class Config
{
    protected array $config = [];
    protected array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cache[$key] ?? $this->addToCache(
                $key,
                $this->extractFromConfig($key) ?? $default
            );
    }

    protected function extractFromConfig(string $key): mixed
    {
        $filtered = $this->config;

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $filtered)) {
                $filtered = $filtered[$segment];
                continue;
            }
            return null;
        }

        return $filtered;
    }

    protected function addToCache($key, mixed $value): mixed
    {
        $this->cache[$key] = $value;

        return $value;
    }

    public function load(array $loaders): self
    {
        foreach ($loaders as $loader) {
            if (!$loader instanceof LoaderInterface) {
                continue;
            }

            $this->config += $loader->parse();
        }

        return $this;
    }
}
