<?php

declare(strict_types=1);

namespace App\Security\Validation;

use Doctrine\ORM\EntityManager;

class ExistsRule
{
    public function __construct(protected EntityManager $db)
    {
    }

    public function validate(string $field, string $value, array $params, array $fields): bool
    {
        $result = $this->db->getRepository($params[0])->findOneBy([
            $field => $value
        ]);

        return $result === null;
    }
}
