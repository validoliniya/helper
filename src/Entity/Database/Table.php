<?php

namespace App\Entity\Database;

use App\Repository\Database\TableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TableRepository::class)
 * @ORM\Table(name="`hms_table`")
 */
class Table
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Database", inversedBy="database")
     */
    private Database $database;

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

    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function setDatabase(Database $database) :self
    {
        $this->database = $database;

        return $this;
    }
}
