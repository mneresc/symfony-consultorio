<?php

namespace App;

use App\Factory\EntidadeFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected $repository;
    protected $entityManager;
    protected $factory;

    public function __construct(ObjectRepository $repository, EntityManagerInterface $entityManager, EntidadeFactory $factory)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->factory = $factory;
    }

    public function findAll(Request $request): Response
    {
        return new JsonResponse($this->repository->findAll());
    }

    public function find(int $id): Response
    {
        $item = $this->repository->find($id);
        $codRetorno = $item ? Response::HTTP_OK: Response::HTTP_NO_CONTENT ;

        return new JsonResponse($item , $codRetorno);
    }

    public function remove(int $id, Request $request):Response{
        $entidade = $this->repository->find($id);
        if(!$entidade){
            return new JsonResponse('' , Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($entidade);
        $this->entityManager->flush();
        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

    public function create(Request $request): Response
    {
        $entidade = $this->factory->preencher($request->getContent());
        $this->entityManager->persist($entidade);
        $this->entityManager->flush();
        return new JsonResponse($entidade);
    }

    public function update(int $id, Request $request):Response{
        $entidadeEnviada = $this->factory->preencher($request->getContent());
        $entidade = $this->repository->find($id);

        $entidade = $this->atualizarEntidade($entidade, $entidadeEnviada);

        $this->entityManager->persist($entidade);
        $this->entityManager->flush();
        return new JsonResponse($entidade);
    }

    abstract public function atualizarEntidade($entidadeExistente, $entidadeEnviada);
}