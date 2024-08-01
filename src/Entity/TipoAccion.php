<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Accion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoAccionRepository")
 * @UniqueEntity(fields="nombre", message="Tipo de acción ya existe")
 */
class TipoAccion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Accion", mappedBy="tipoaccion")
     */
    private $acciones;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->acciones = new ArrayCollection();
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

    /**
     * @return Collection|Accion[]
     */
    public function getAcciones(): Collection
    {
        /**
         * @var Collection|Accion[] $collection
         */
        $collection = new ArrayCollection();

        /**
         * @var Accion $acciones
         */
        $acciones = $this->acciones;
        foreach ($acciones as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item);
            }
        }
        return $collection;
    }

    public function addAccion(Accion $acciones): self
    {
        if (!$this->acciones->contains($acciones)) {
            $this->acciones[] = $acciones;
            $acciones->setNivel($this);
        }

        return $this;
    }

    public function removeAccion(Accion $acciones): self
    {
        if ($this->acciones->contains($acciones)) {
            $this->acciones->removeElement($acciones);
            // set the owning side to null (unless already changed)
            if ($acciones->getNivel() === $this) {
                $acciones->setNivel(null);
            }
        }

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
}
