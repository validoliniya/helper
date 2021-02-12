<?php

namespace App\Entity;

use App\Repository\FieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FieldRepository::class)
 * @ORM\Table(name="`hms_field`")
 */
class Field
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
     * @ORM\OneToMany(targetEntity=TableFields::class, mappedBy="Field")
     */
    private $tableFields;

    public function __construct()
    {
        $this->tableFields = new ArrayCollection();
    }

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

    /**
     * @return Collection|TableFields[]
     */
    public function getTableFields(): Collection
    {
        return $this->tableFields;
    }

    public function addTableField(TableFields $tableField): self
    {
        if (!$this->tableFields->contains($tableField)) {
            $this->tableFields[] = $tableField;
            $tableField->setField($this);
        }

        return $this;
    }

    public function removeTableField(TableFields $tableField): self
    {
        if ($this->tableFields->removeElement($tableField)) {
            // set the owning side to null (unless already changed)
            if ($tableField->getField() === $this) {
                $tableField->setField(null);
            }
        }

        return $this;
    }
}
