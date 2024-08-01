<?php

namespace App\Entity;

use App\Repository\ObjetivoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ObjetivoEntidad;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ObjetivoRepository::class)
 * @UniqueEntity(fields="nombre", message="El objetivo ya existe")
 */
class Objetivo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjetivoEntidad", mappedBy="objetivo")
     */
    private $entidades;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->activo = true;
        $this->entidades = new ArrayCollection();
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
    public function getEntidades(): Collection
    {
        /**
         * @var Collection|ObjetivoEntidad[] $collection
         */
        $collection = new ArrayCollection();
        /**
         * @var ObjetivoEntidad $entidades
         */
        $entidades = $this->entidades;
        foreach ($entidades as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item);
            }
        }

        return $collection;
    }

    public function addEntidad(ObjetivoEntidad $entidades): self
    {
        if (!$this->entidades->contains($entidades)) {
            $this->entidades[] = $entidades;
            $entidades->setObjetivo($this);
        }

        return $this;
    }

    public function removeEntidad(ObjetivoEntidad $entidades): self
    {
        if ($this->entidades->contains($entidades)) {
            $this->entidades->removeElement($entidades);
            // set the owning side to null (unless already changed)
            if ($entidades->getObjetivo() === $this) {
                $entidades->setObjetivo(null);
            }
        }

        return $this;
    }
}
