<?php

namespace App\Entity;

use App\Repository\LoyaltyCardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoyaltyCardRepository::class)
 */
class LoyaltyCard
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string {
        return $this->number;
    }

    public function setNumber(?string $number): self {
        $this->number = $number;

        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

}
