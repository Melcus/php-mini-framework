<?php

declare(strict_types=1);

namespace App\Entities;

use UnexpectedValueException;

abstract class BaseEntity
{
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }

    public function __set(string $property, mixed $value)
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
            return $this;
        }

        throw new UnexpectedValueException("Property $property does not exist");
    }

    public function __isset(string $property): bool
    {
        return property_exists($this, $property);
    }

    public function update(array $data): bool
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        return true;
    }

    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }
}
