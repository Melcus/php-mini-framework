<?php

declare(strict_types=1);

namespace App\Entities;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping AS ORM;

#[ORM\Entity]
#[ORM\Table('bookings')]
class Booking extends BaseEntity
{
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\Column(name: 'date', type: Types::DATE_MUTABLE, nullable: false)]
    protected DateTime $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    protected User $user;
}