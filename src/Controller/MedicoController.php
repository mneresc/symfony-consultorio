<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Repository\EspecialidadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MedicoController extends AbstractController
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
     * @Route("/medico", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $corpoReq = \json_decode($request->getContent());

        $medico = new Medico();
        $medico->setCrm($corpoReq->crm);
        $medico->setNome( $corpoReq->nome);
        $medico->setEspecialidade($this->especialidadeRepository->find($corpoReq->especialidadeId));

        $this->entityManager->persist($medico);
        $this->entityManager->flush();
        return new JsonResponse($medico);
    }

    /**
     * @Route("/medico", methods={"GET"})
     */
    public function findAll(Request $request): Response
    {
        $medRepo = $this->getDoctrine()->getRepository(Medico::class);
        return new JsonResponse($medRepo->findAll());
    }


    /**
     * @Route("/medico/{id}", methods={"GET"})
     */
    public function find(Request $request): Response
    {
        $medico = $this->getMedico($request->get('id'));
        $codRetorno = $medico ? Response::HTTP_OK: Response::HTTP_NO_CONTENT ;

        return new JsonResponse($medico , $codRetorno);
    }

    /**
     * @Route("/medico/{id}", methods={"PUT"})
     */
    public function update(Request $request):Response{
        $corpoReq = \json_decode($request->getContent());
        $id = $request->get('id');

        $medico = $this->getMedico($id);

        if(!$medico){
            return new JsonResponse('' , Response::HTTP_NOT_FOUND);
        }

        $medico->setCrm($corpoReq->crm);
        $medico->setNome( $corpoReq->nome);
        $medico->setEspecialidade($this->especialidadeRepository->find($corpoReq->especialidadeId));

        $this->entityManager->flush();

        return new JsonResponse($medico);
    }


    /**
     * @Route("/medico/{id}", methods={"DELETE"})
     */
    public function remove(Request $request):Response{
        $id = $request->get('id');
        $medico = $this->getMedico($id);

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
    public function getMedico($id)
    {
        $medRepo = $this->getDoctrine()->getRepository(Medico::class);
        return $medRepo->find($id);
    }


}