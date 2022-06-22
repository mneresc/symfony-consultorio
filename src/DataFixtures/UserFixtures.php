<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $usuario = new User();
        $usuario->setUsername('usuario');
        $usuario->setPassword('$argon2id$v=19$m=65536,t=4,p=1$Gd3SEeRrERnG9hyTxEcAGA$VQ7X7jdo1LlaT/xExkiNcjpY/vjm2EkL19RXY5caiyg');
        $manager->persist($usuario);

        $manager->flush();
    }
}
