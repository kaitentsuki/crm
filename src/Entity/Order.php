<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LoyaltyCard", inversedBy="id")
     * @ORM\JoinColumn(name="loyalty_card", referencedColumnName="id")
     */
    private $loyalty_card;

    /**
     * @ORM\Column(type="array")
     */
    private $items;

    /**
     * @ORM\Column(type="integer")
     */
    private $final_price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    public function __construct()
    {
        $this->date_created = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoyaltyCard()
    {
        return $this->loyalty_card;
    }

    public function setLoyaltyCard($loyalty_card): self
    {
        $this->loyalty_card = $loyalty_card;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items): self
    {
        $this->items = $items;

        $price = 0;

        foreach ($this->items as $item) {
            $price = $price + $item->getPricePerUnit()*$item->getAmount();
        }

        $this->final_price = $price;

        return $this;
    }
}
