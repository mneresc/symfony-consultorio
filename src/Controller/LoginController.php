<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends AbstractController
{
    private $repository;
    private $encoder;
    private const ALGO_JWT = "HS256";

    public function __construct(UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function index(Request $request): Response
    {
        $campos = json_decode($request->getContent());

        if (is_null($campos->username) || is_null($campos->password)) {
            return new JsonResponse(
                ['erro' => 'Usuário ou senha não enviados'],
                Response::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE);
        }

        $usuario = $this->repository->findOneBy(['username' => $campos->username]);

        if (!$this->encoder->isPasswordValid($usuario, $campos->password)) {
            return new JsonResponse(
                ['erro' => 'Usuário ou senha incorretos'],
                Response::HTTP_UNAUTHORIZED
            );
        }

       $token =  JWT::encode(['username' => $usuario->getUsername()],'chave',self::ALGO_JWT);

        return new JsonResponse([
            'access_token' => $token,
        ]);
    }
}
