<?php

namespace App\Entity\Work;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Timer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Task::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Task $task;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private \DateTime $tempDate;

    /**
     * @ORM\Column(type="integer")
     */
    private int $hours = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $minutes = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getTempDate(): \DateTime
    {
        return $this->tempDate;
    }

    public function setTempDate(\DateTime $tempDate): Timer
    {
        $this->tempDate = $tempDate;

        return $this;
    }

    public function getHours(): int
    {
        return $this->hours;
    }

    public function setHours(int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }

    public function getTime(): string
    {
        return sprintf('%s:%s', $this->hours, $this->minutes);
    }

}
