<?php

namespace App\Factory;

use App\Entity\Especialidade;

class EspecialidadeFactory implements EntidadeFactory
{
    public function preencher(string $json): Especialidade
    {
        $corpoReq = \json_decode($json);
        $entidade = new Especialidade();
        $entidade->setDescricao($corpoReq->descricao);
        return $entidade;
    }
}