<?php

namespace App\Entity;

use App\Repository\TableFieldsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TableFieldsRepository::class)
 */
class TableFields
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Table::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $hmsTable;

    /**
     * @ORM\ManyToOne(targetEntity=Field::class, inversedBy="tableFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Field;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHmsTable(): ?Table
    {
        return $this->hmsTable;
    }

    public function setHmsTable(?Table $hmsTable): self
    {
        $this->hmsTable = $hmsTable;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->Field;
    }

    public function setField(?Field $Field): self
    {
        $this->Field = $Field;

        return $this;
    }
}
