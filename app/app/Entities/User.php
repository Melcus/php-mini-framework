<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping AS ORM;

#[ORM\Entity]
#[ORM\Table('users')]
class User extends BaseEntity
{
    public function __construct() {
        $this->bookings = new ArrayCollection();
    }

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    protected string $name;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 255, nullable: false)]
    protected string $email;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: false)]
    protected string $password;

    #[ORM\Column(name: 'remember_token', type: Types::STRING, length: 255, nullable: true)]
    protected string $remember_token;

    #[ORM\Column(name: 'remember_identifier', type: Types::STRING, length: 255, nullable: true)]
    protected string $remember_identifier;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Booking::class)]
    protected $bookings;
}
