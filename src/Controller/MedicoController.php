<?php

namespace App\Controller;

use App\BaseController;
use App\Factory\MedicoFactory;
use App\Repository\EspecialidadeRepository;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;


class MedicoController extends BaseController
{

    public function __construct(EspecialidadeRepository $especialidadeRepository, MedicoRepository $medicosRepository, EntityManagerInterface $entityManager, MedicoFactory $factory)
    {
        parent::__construct($medicosRepository, $entityManager, $factory);
        $this->especialidadeRepository = $especialidadeRepository;
        $this->factory = $factory;
    }

    public function atualizarEntidade($entidadeExistente, $entidadeEnviada)
    {
        $entidadeExistente->setNome($entidadeEnviada->getNome())
            ->setNome($entidadeEnviada->getNome())
            ->setEspecialidade($entidadeEnviada->getEspecialidade());

        return $entidadeExistente;
    }
}