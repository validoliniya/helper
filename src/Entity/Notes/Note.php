<?php

namespace App\Entity\Notes;

use App\Repository\Database\DatabaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="hms_note")
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=2255)
     */
    private string $text = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Note
     */
    public function setText(string $text): Note
    {
        $this->text = $text;

        return $this;
    }
}
