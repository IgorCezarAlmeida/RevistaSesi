<?php

declare(strict_types=1);

namespace App\DAO;

use App\Model\Curtida;
use App\Model\Usuario;
use App\Model\Artigo;
use Doctrine\ORM\EntityManager;

final class CurtidaDAO
{
    public function __construct(private readonly EntityManager $em) {}

    public function findByUsuarioEArtigo(Usuario $usuario, Artigo $artigo): ?Curtida
    {
        return $this->em->getRepository(Curtida::class)->findOneBy([
            'usuario' => $usuario,
            'artigo' => $artigo,
        ]);
    }

    public function toggle(Usuario $usuario, Artigo $artigo): void
    {
        $curtida = $this->findByUsuarioEArtigo($usuario, $artigo);
        if ($curtida instanceof Curtida) {
            $this->em->remove($curtida);
        } else {
            $curtida = new Curtida();
            $curtida->setUsuario($usuario);
            $curtida->setArtigo($artigo);
            $this->em->persist($curtida);
        }

        $this->em->flush();
    }
}
