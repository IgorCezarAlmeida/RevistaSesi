<?php

declare(strict_types=1);

namespace App\DAO;

use App\Model\Comentario;
use Doctrine\ORM\EntityManager;

final class ComentarioDAO
{
    public function __construct(private readonly EntityManager $em) {}

    /** @return Comentario[] */
    public function findByArtigo(int $artigoId): array
    {
        return $this->em->createQueryBuilder()
            ->select('c', 'u')
            ->from(Comentario::class, 'c')
            ->join('c.usuario', 'u')
            ->where('IDENTITY(c.artigo) = :artigoId')
            ->setParameter('artigoId', $artigoId)
            ->orderBy('c.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findById(int $id): ?Comentario
    {
        return $this->em->find(Comentario::class, $id);
    }

    public function save(Comentario $comentario): void
    {
        $this->em->persist($comentario);
        $this->em->flush();
    }

    public function delete(Comentario $comentario): void
    {
        $this->em->remove($comentario);
        $this->em->flush();
    }
}
