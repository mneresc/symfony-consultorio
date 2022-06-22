<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseFactory
{
    public bool $sucesso;
    public int $paginaAtual;
    public int $itensorPagina;
    public $conteudoResposta;

    public function __construct(bool $sucesso, int $paginaAtual, int $itensorPagina, $conteudoResposta)
    {
        $this->sucesso = $sucesso;
        $this->paginaAtual = $paginaAtual;
        $this->itensorPagina = $itensorPagina;
        $this->conteudoResposta = $conteudoResposta;
    }

    public function getResponse()
    {
        $resposta = [
            'sucesso' => $this->sucesso,
            'paginaAtual' => $this->paginaAtual,
            'itensorPagina' => $this->itensorPagina,
            'conteudoResposta' => $this->conteudoResposta
        ];
        return new JsonResponse($resposta);
    }
}