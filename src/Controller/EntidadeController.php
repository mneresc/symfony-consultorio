<?php

namespace App\Controller;

use App\Entity\Especialidade;
use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntidadeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $especialidadeRepository;

    public function __construct(EntityManagerInterface $entityManager, EspecialidadeRepository $especialidadeRepository)
    {
        $this->entityManager = $entityManager;
        $this->especialidadeRepository = $especialidadeRepository;
    }

    /**
     * @Route("/entidade", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $corpoReq = \json_decode($request->getContent());

        $especialidade = new Especialidade();
        $especialidade->setDescricao($corpoReq->descricao);

        $this->entityManager->persist($especialidade);
        $this->entityManager->flush();
        return new JsonResponse($especialidade);
    }

    /**
     * @Route("/entidade", methods={"GET"})
     */
    public function findAll(Request $request): Response
    {
        return new JsonResponse($this->especialidadeRepository->findAll());
    }


    /**
     * @Route("/entidade/{id}", methods={"GET"})
     */
    public function find(Request $request): Response
    {
        $medico = $this->getEntidade($request->get('id'));
        $codRetorno = $medico ? Response::HTTP_OK: Response::HTTP_NO_CONTENT ;

        return new JsonResponse($medico , $codRetorno);
    }

    /**
     * @Route("/entidade/{id}", methods={"PUT"})
     */
    public function update(Request $request):Response{
        $corpoReq = \json_decode($request->getContent());
        $id = $request->get('id');

        $especialidade = $this->getEntidade($id);

        if(!$especialidade){
            return new JsonResponse('' , Response::HTTP_NOT_FOUND);
        }

        $especialidade->setDescricao($corpoReq->descricao);

        $this->entityManager->flush();

        return new JsonResponse($especialidade);
    }


    /**
     * @Route("/entidade/{id}", methods={"DELETE"})
     */
    public function remove(Request $request):Response{
        $id = $request->get('id');
        $medico = $this->getEntidade($id);

        if(!$medico){
            return new JsonResponse('' , Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($medico);

        $this->entityManager->flush();

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $id
     * @return Medico|mixed|object|null
     */
    public function getEntidade($id) : ?Especialidade
    {
        return $this->especialidadeRepository->find($id);
    }
}
