<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Medico
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="integer")
     */
    public $crm;

    /**
     * @ORM\Column(type="string")
     */
    public $nome;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class, inversedBy="medicos")
     */
    private $especialidade;


    public function __construct()
    {
        $this->especialidade = new ArrayCollection();
    }

    public function getEspecialidade(): ?Especialidade
    {
        return $this->especialidade;
    }

    public function setEspecialidade(?Especialidade $especialidade): self
    {
        $this->especialidade = $especialidade;

        return $this;
    }
}