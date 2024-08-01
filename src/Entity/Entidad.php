<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ObjetivoEntidad;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntidadRepository")
 * @UniqueEntity(fields="nombre", message="La entidad ya existe")
 */
class Entidad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjetivoEntidad", mappedBy="entidad")
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
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $objetivos->setEntidad($this);
        }

        return $this;
    }

    public function removeObjetivo(ObjetivoEntidad $objetivos): self
    {
        if ($this->objetivos->contains($objetivos)) {
            $this->objetivos->removeElement($objetivos);
            // set the owning side to null (unless already changed)
            if ($objetivos->getEntidad() === $this) {
                $objetivos->setEntidad(null);
            }
        }

        return $this;
    }
}
