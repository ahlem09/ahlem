<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ORM\Table(name: '`show`')]
class Show
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $numshow;

    #[ORM\Column(type: 'integer')]
    private $nbrseat;

    #[ORM\Column(type: 'datetime')]
    private $dateshow;

    #[ORM\ManyToOne(targetEntity: TheatrePlay::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $theatrePlay;

    // Getter et Setter pour Numshow
    public function getNumshow(): ?int
    {
        return $this->numshow;
    }

    // Getter et Setter pour Nbrseat
    public function getNbrseat(): ?int
    {
        return $this->nbrseat;
    }

    public function setNbrseat(int $nbrseat): self
    {
        $this->nbrseat = $nbrseat;
        return $this;
    }

    // Getter et Setter pour Dateshow
    public function getDateshow(): ?\DateTimeInterface
    {
        return $this->dateshow;
    }

    public function setDateshow(\DateTimeInterface $dateshow): self
    {
        $this->dateshow = $dateshow;
        return $this;
    }

    // Getter et Setter pour TheatrePlay
    public function getTheatrePlay(): ?TheatrePlay
    {
        return $this->theatrePlay;
    }

    public function setTheatrePlay(?TheatrePlay $theatrePlay): self
    {
        $this->theatrePlay = $theatrePlay;
        return $this;
    }
}
