<?php

namespace App\Entity\Work;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Entity
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
    private $time;

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

    public function getTime():int
    {
        return $this->time;
    }

    public function setTime(int $time):self
    {
        $this->time = $time;

        return $this;
    }

}
