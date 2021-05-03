<?php

namespace App\Entity\Command;

use App\Repository\Command\CommandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 * @ORM\Table(name="`hms_command`")
 */
class Command
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
     * @ORM\Column(type="string", length=255)
     */
    private ?string $template = '';

    /**
     * @ORM\Column(type="boolean")
     */
    private $isImmutable = true;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $example = '';

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

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function isImmutable(): ?bool
    {
        return $this->isImmutable;
    }

    public function setImmutable(bool $isImmutable): self
    {
        $this->isImmutable = $isImmutable;

        return $this;
    }

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(string $example): self
    {
        $this->example = $example;

        return $this;
    }
}
