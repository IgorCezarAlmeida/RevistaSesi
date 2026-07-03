<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'usuarios')]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 120)]
    private string $nome;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $senha;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isAdmin = false;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'autor', targetEntity: Artigo::class)]
    private Collection $artigos;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Comentario::class)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Curtida::class)]
    private Collection $curtidas;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->artigos = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->curtidas = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function getSenha(): string { return $this->senha; }
    public function setSenha(string $senha): void { $this->senha = $senha; }
    public function isAdmin(): bool { return $this->isAdmin; }
    public function setIsAdmin(bool $isAdmin): void { $this->isAdmin = $isAdmin; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
