<?php

namespace App\Entity;

use App\Repository\AccionRepository;
use App\Entity\TipoAccion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\ObjetivoEntidad;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AccionRepository::class)
 * @UniqueEntity(fields="nombre", message="La acción ya existe")
 */
class Accion
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
     * @ORM\Column(type="string", length=70, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoAccion", inversedBy="acciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoaccion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjetivoEntidad", mappedBy="acciones")
     */
    private $objetivos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->objetivos = new ArrayCollection();
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

    public function getTipoAccion(): ?TipoAccion
    {
        return $this->tipoaccion;
    }

    public function setTipoAccion(?TipoAccion $tipoaccion): self
    {
        $this->tipoaccion = $tipoaccion;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
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

    /**
     * @return Collection|ObjetivoEntidad[]
     */
    public function getObjetivos(): Collection
    {
        /**
         * @var Collection|ObjetivoEntidad[] $collection
         */
        $collection = new ArrayCollection();

        /**
         * @var ObjetivoEntidad $objetivos
         */
        $objetivos = $this->objetivos;
        foreach ($objetivos as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item);
            }
        }
        return $collection;
    }

    public function addObjetivo(ObjetivoEntidad $objetivos): self
    {
        if (!$this->objetivos->contains($objetivos)) {
            $this->objetivos[] = $objetivos;
            $objetivos->setAccion($this);
        }

        return $this;
    }

    public function removeObjetivo(ObjetivoEntidad $objetivos): self
    {
        if ($this->objetivos->contains($objetivos)) {
            $this->objetivos->removeElement($objetivos);
            // set the owning side to null (unless already changed)
            if ($objetivos->getAccion() === $this) {
                $objetivos->setAccion(null);
            }
        }

        return $this;
    }


    public function DateTimeToString(\DateTimeInterface $fecha)
    {
        $year = date('Y', date_timestamp_get($fecha));
        $month = date('m', date_timestamp_get($fecha));
        $day = date('d', date_timestamp_get($fecha));
        $hour = date('h', date_timestamp_get($fecha));
        $min = date('i', date_timestamp_get($fecha));
        $seg = date('s', date_timestamp_get($fecha));

        return $year.''.$month.''.$day.''.$hour.''.$min.''.$seg;
    }

}
