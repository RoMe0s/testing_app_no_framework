<?php

namespace Domain\Task;

use Doctrine\ORM\Mapping as ORM;
use Domain\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Task
{
    public const STATUS_NEW = 'new';
    public const STATUS_DONE = 'done';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private int $id;

    /**
     * @ORM\OneToOne(targetEntity="\Domain\User\User")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="id", nullable=true)
     * @var User|null $admin
     */
    private ?User $admin = null;

    /**
     * @ORM\Column(type="string", name="user_name")
     * @var string
     */
    private string $userName;

    /**
     * @ORM\Column(type="string", name="user_email")
     * @var string
     */
    private string $userEmail;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private string $description;

    /**
     * @ORM\Column(type="string", options={"default": "CREATED"})
     * @var string
     */
    private string $status = self::STATUS_NEW;

    public function getId(): int
    {
        return $this->id;
    }

    public function setAdmin(User $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function hasAdmin(): bool
    {
        return $this->admin instanceof User;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;
        return $this;
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}