<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping AS ORM;

#[ORM\Entity]
#[ORM\Table('users')]
class User extends BaseEntity
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    protected string $name;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 255, nullable: false)]
    protected string $email;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: false)]
    protected string $password;
}
