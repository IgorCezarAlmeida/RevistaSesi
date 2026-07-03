<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'comentarios')]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $conteudo;

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'comentarios')]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\ManyToOne(targetEntity: Artigo::class, inversedBy: 'comentarios')]
    #[ORM\JoinColumn(name: 'artigo_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Artigo $artigo;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getConteudo(): string { return $this->conteudo; }
    public function setConteudo(string $conteudo): void { $this->conteudo = $conteudo; }
    public function getUsuario(): Usuario { return $this->usuario; }
    public function setUsuario(Usuario $usuario): void { $this->usuario = $usuario; }
    public function getArtigo(): Artigo { return $this->artigo; }
    public function setArtigo(Artigo $artigo): void { $this->artigo = $artigo; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
