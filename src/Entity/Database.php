<?php

namespace App\Entity;

use App\Repository\DatabaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="databases_table")
 * @ORM\Entity(repositoryClass=DatabaseRepository::class)
 */
class Database
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
