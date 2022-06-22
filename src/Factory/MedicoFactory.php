<?php

namespace App\Factory;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;

class MedicoFactory implements EntidadeFactory
{
    private EspecialidadeRepository $repository;

    public function __construct(EspecialidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function preencher(string $json): Medico
    {
        $corpoReq = \json_decode($json);
        $medico = new Medico();
        $medico->setCrm($corpoReq->crm);
        $medico->setNome($corpoReq->nome);
        $medico->setEspecialidade($this->repository->find($corpoReq->especialidadeId));
        return $medico;
    }
}