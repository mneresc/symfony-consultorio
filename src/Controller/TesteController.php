<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesteController
{

    /**
     * @Route("/teste")
     */
    public function teste(Request $request) : Response{
        $path = $request->getPathInfo();
        $queryString = $request->query->all();
        return new JsonResponse(['mensagem'=> 'teste','path' => $path,'query'=>$queryString]);
    }
}