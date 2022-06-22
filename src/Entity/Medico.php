<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\MedicoRepository::class)
 */
class Medico implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $crm;

    /**
     * @ORM\Column(type="string")
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity=Especialidade::class, inversedBy="medicos")
     */
    private $especialidade;


    public function __construct()
    {
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

    /**
     * @return mixed
     */
    public function getCrm()
    {
        return $this->crm;
    }

    /**
     * @param mixed $crm
     */
    public function setCrm($crm): self
    {
        $this->crm = $crm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'crm' => $this->getCrm(),
            'especialidade' => $this->getEspecialidade() ? $this->getEspecialidade()->getId() : null
        ];
    }

}