<?php

namespace App\Entity;

use App\Repository\AccionPAMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AccionPAMRepository::class)
 */
class AccionPAM
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $responsables;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\NotBlank()
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LineaEstrategica", inversedBy="acciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $linea;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->activo = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getResponsables(): ?string
    {
        return $this->responsables;
    }

    public function setResponsables(string $responsables): self
    {
        $this->responsables = $responsables;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

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

    public function getLinea(): ?LineaEstrategica
    {
        return $this->linea;
    }

    public function setLinea(?LineaEstrategica $lineaEstrategica): self
    {
        $this->linea = $lineaEstrategica;

        return $this;
    }
}
