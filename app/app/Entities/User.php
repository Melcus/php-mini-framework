<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity @ORM\Table(name="users")
 */
class User extends BaseEntity
{
    /**
     * @ORM\Id @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected string $name;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected string $email;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected string $password;
}
