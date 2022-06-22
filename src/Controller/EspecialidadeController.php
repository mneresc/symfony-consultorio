<?php

namespace App\Controller;

use App\BaseController;
use App\Entity\Medico;
use App\Factory\EntidadeFactory;
use App\Factory\EspecialidadeFactory;
use App\Repository\EspecialidadeRepository;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadeController extends BaseController
{
    /**
     * @var EntityManagerInterface
     */
    private $medicoRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepository, MedicoRepository $medicoRepository, EntityManagerInterface $entityManager, EspecialidadeFactory $factory)
    {
        parent::__construct($especialidadeRepository, $entityManager, $factory);
        $this->medicoRepository = $medicoRepository;
    }


    /**
     * @Route("/entidade/{especialidadeId}/medico", methods={"GET"})
     */
    public function findByEspecialidade(int $especialidadeId, Request $request): Response
    {
        return new JsonResponse($this->medicoRepository->findBy(['especialidade' => $especialidadeId]));
    }

    public function atualizarEntidade($entidadeExistente, $entidadeEnviada)
    {
        $entidadeExistente->setDescricao($entidadeEnviada->getDescricao());
        return $entidadeExistente;
    }
}
