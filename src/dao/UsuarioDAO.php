<?php

declare(strict_types=1);

namespace App\DAO;

use App\Model\Usuario;
use Doctrine\ORM\EntityManager;

final class UsuarioDAO
{
    public function __construct(private readonly EntityManager $em) {}

    public function findById(int $id): ?Usuario
    {
        return $this->em->find(Usuario::class, $id);
    }

    public function findByEmail(string $email): ?Usuario
    {
        return $this->em->getRepository(Usuario::class)->findOneBy(['email' => $email]);
    }

    /** @return Usuario[] */
    public function findAll(): array
    {
        return $this->em->getRepository(Usuario::class)->findBy([], ['id' => 'DESC']);
    }

    public function save(Usuario $usuario): void
    {
        $this->em->persist($usuario);
        $this->em->flush();
    }
}
