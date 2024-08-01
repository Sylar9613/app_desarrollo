<?php

namespace App\Entity;

use App\Repository\ObjetivoEntidadRepository;
use App\Entity\Entidad;
use App\Entity\Objetivo;
use App\Entity\Accion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ObjetivoEntidadRepository::class)
 * @UniqueEntity(fields={"entidad", "objetivo", "acciones"}, message="Este objetivo ya está asociado a esta entidad")
 */
class ObjetivoEntidad
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entidad", inversedBy="objetivos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Objetivo", inversedBy="entidades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $objetivo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $deficiencias;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $recomendaciones;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $seguimiento;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Accion", inversedBy="objetivos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acciones;

    public function __construct()
    {
        $this->activo = true;
    }

    public function getEntidad(): ?Entidad
    {
        return $this->entidad;
    }

    public function setEntidad(?Entidad $entidad): self
    {
        $this->entidad = $entidad;

        return $this;
    }

    public function getObjetivo(): ?Objetivo
    {
        return $this->objetivo;
    }

    public function setObjetivo(?Objetivo $objetivo): self
    {
        $this->objetivo = $objetivo;

        return $this;
    }

    public function getDeficiencias(): ?string
    {
        return $this->deficiencias;
    }

    public function setDeficiencias(string $deficiencias): self
    {
        $this->deficiencias = $deficiencias;

        return $this;
    }

    public function getRecomendaciones(): ?string
    {
        return $this->recomendaciones;
    }

    public function setRecomendaciones(string $recomendaciones): self
    {
        $this->recomendaciones = $recomendaciones;

        return $this;
    }

    public function getSeguimiento(): ?string
    {
        return $this->seguimiento;
    }

    public function setSeguimiento(string $seguimiento): self
    {
        $this->seguimiento = $seguimiento;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getAcciones(): ?Accion
    {
        return $this->acciones;
    }

    public function setAcciones(?Accion $acciones): self
    {
        $this->acciones = $acciones;

        return $this;
    }
}
