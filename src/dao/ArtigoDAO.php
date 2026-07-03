<?php

declare(strict_types=1);

namespace App\DAO;

use App\Model\Artigo;
use Doctrine\ORM\EntityManager;

final class ArtigoDAO
{
    public function __construct(private readonly EntityManager $em) {}

    public function findById(int $id): ?Artigo
    {
        return $this->em->find(Artigo::class, $id);
    }

    /** @return Artigo[] */
    public function latest(int $limit = 20): array
    {
        return $this->em->getRepository(Artigo::class)->findBy([], ['createdAt' => 'DESC'], $limit);
    }

    /** @return Artigo[] */
    public function search(string $term): array
    {
        return $this->em->createQueryBuilder()
            ->select('a')
            ->from(Artigo::class, 'a')
            ->where('a.titulo LIKE :term OR a.resumo LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function save(Artigo $artigo): void
    {
        $this->em->persist($artigo);
        $this->em->flush();
    }

    public function delete(Artigo $artigo): void
    {
        $this->em->remove($artigo);
        $this->em->flush();
    }
}
