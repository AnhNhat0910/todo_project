<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TodoRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');
class Todo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

     /**
     * @ORM\Column(type= "string", length= 255)
     */
    private $name;

     /**
     * @ORM\Column(type= "string", length= 255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status ='0';

    /**
     * @ORM\Column(type="date")
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastModificationTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = '1';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletionTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getLastModificationTime(): ?\DateTimeInterface
    {
        return $this->lastModificationTime;
    }

    public function setLastModificationTime(?\DateTimeInterface $lastModificationTime): self
    {
        $this->lastModificationTime = $lastModificationTime;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getDeletionTime(): ?\DateTimeInterface
    {
        return $this->deletionTime;
    }

    public function setDeletionTime(?\DateTimeInterface $deletionTime): self
    {
        $this->deletionTime = $deletionTime;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreateDateValue(): void
    {
        $date = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
        $this->createDate = $date;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateLastModificationTimeValue(): void
    {
        $timeMofify = DateTime::createFromFormat('Y-m-d h:i', date('Y-m-d h:i'));
        $this->lastModificationTime = $timeMofify;
    }

     /**
     * @ORM\PreRemove
     */
    public function setDeletionTimeValue(): void
    {
        $deletionTime = DateTime::createFromFormat('Y-m-d h:i', date('Y-m-d h:i'));
        $this->deletionTime = $deletionTime;
    }

}
