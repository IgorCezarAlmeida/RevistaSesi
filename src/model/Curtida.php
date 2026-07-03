<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'curtidas', uniqueConstraints: [new ORM\UniqueConstraint(name: 'uniq_curtida_usuario_artigo', columns: ['usuario_id', 'artigo_id'])])]
class Curtida
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'curtidas')]
    #[ORM\JoinColumn(name: 'usuario_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $usuario;

    #[ORM\ManyToOne(targetEntity: Artigo::class, inversedBy: 'curtidas')]
    #[ORM\JoinColumn(name: 'artigo_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Artigo $artigo;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getUsuario(): Usuario { return $this->usuario; }
    public function setUsuario(Usuario $usuario): void { $this->usuario = $usuario; }
    public function getArtigo(): Artigo { return $this->artigo; }
    public function setArtigo(Artigo $artigo): void { $this->artigo = $artigo; }
}

