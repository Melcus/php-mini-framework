<?php

declare(strict_types=1);

namespace App\Providers;

use App\Security\Validation\ExistsRule;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Valitron\Validator;

class ValidationServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function provides(string $id): bool
    {
        return false;
    }

    public function register(): void
    {
    }

    public function boot(): void
    {
        Validator::addRule('exists', function (string $field, string $value, array $params, array $fields) {
            return (new ExistsRule(
                $this->container->get(EntityManager::class)
            ))->validate($field, $value, $params, $fields);
        }, 'already exists in the database');
    }
}
