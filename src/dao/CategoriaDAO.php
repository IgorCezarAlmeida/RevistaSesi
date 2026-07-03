<?php

declare(strict_types=1);

namespace App\DAO;

use App\Model\Categoria;
use Doctrine\ORM\EntityManager;

final class CategoriaDAO
{
    public function __construct(private readonly EntityManager $em) {}

    public function findById(int $id): ?Categoria
    {
        return $this->em->find(Categoria::class, $id);
    }

    /** @return Categoria[] */
    public function findAll(): array
    {
        return $this->em->getRepository(Categoria::class)->findBy([], ['nome' => 'ASC']);
    }

    public function save(Categoria $categoria): void
    {
        $this->em->persist($categoria);
        $this->em->flush();
    }
}
