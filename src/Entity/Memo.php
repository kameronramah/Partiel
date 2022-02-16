<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoRepository::class)]
class Memo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $deletedTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDeletedTime(): ?\DateTimeInterface
    {
        return $this->deletedTime;
    }

    public function setDeletedTime(\DateTimeInterface $deletedTime): self
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }
}
