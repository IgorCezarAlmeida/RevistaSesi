<?php

declare(strict_types=1);

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'artigos')]
class Artigo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180)]
    private string $titulo;

    #[ORM\Column(type: Types::TEXT)]
    private string $resumo;

    #[ORM\Column(type: Types::TEXT)]
    private string $conteudo;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imagemCapa = null;

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'artigos')]
    #[ORM\JoinColumn(name: 'autor_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private Usuario $autor;

    #[ORM\ManyToOne(targetEntity: Categoria::class, inversedBy: 'artigos')]
    #[ORM\JoinColumn(name: 'categoria_id', referencedColumnName: 'id', nullable: false, onDelete: 'RESTRICT')]
    private Categoria $categoria;

    #[ORM\OneToMany(mappedBy: 'artigo', targetEntity: Comentario::class)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'artigo', targetEntity: Curtida::class)]
    private Collection $curtidas;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->comentarios = new ArrayCollection();
        $this->curtidas = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function setTitulo(string $titulo): void { $this->titulo = $titulo; }
    public function getResumo(): string { return $this->resumo; }
    public function setResumo(string $resumo): void { $this->resumo = $resumo; }
    public function getConteudo(): string { return $this->conteudo; }
    public function setConteudo(string $conteudo): void { $this->conteudo = $conteudo; }
    public function getImagemCapa(): ?string { return $this->imagemCapa; }
    public function setImagemCapa(?string $imagemCapa): void { $this->imagemCapa = $imagemCapa; }
    public function getAutor(): Usuario { return $this->autor; }
    public function setAutor(Usuario $autor): void { $this->autor = $autor; }
    public function getCategoria(): Categoria { return $this->categoria; }
    public function setCategoria(Categoria $categoria): void { $this->categoria = $categoria; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function touch(): void { $this->updatedAt = new \DateTimeImmutable(); }
    public function getQtdCurtidas(): int { return $this->curtidas->count(); }
}
