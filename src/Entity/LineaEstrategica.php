<?php

namespace App\Entity;

use App\Controller\LineaEstrategicaController;
use App\Entity\AccionPAM;
use App\Entity\PAM;
use App\Repository\LineaEstrategicaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=LineaEstrategicaRepository::class)
 * @UniqueEntity(fields="nombre", message="La línea estratégica ya existe")
 */
class LineaEstrategica
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
     * @ORM\Column(type="string", length=120, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $indicadores;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AccionPAM", mappedBy="linea", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $acciones;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PAM", inversedBy="lineas")
     */
    private $pam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->acciones = new ArrayCollection();
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

    public function getIndicadores(): ?string
    {
        return $this->indicadores;
    }

    public function setIndicadores(?string $indicadores): self
    {
        $this->indicadores = $indicadores;

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
     * @return Collection|AccionPAM[]
     */
    public function getAcciones(): Collection
    {
        /**
         * @var Collection|AccionPAM[] $collection
         */
        $collection = new ArrayCollection();

        /**
         * @var AccionPAM $acciones
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

    public function addAccion(AccionPAM $accionPAM): self
    {
        if (!$this->acciones->contains($accionPAM)) {
            $this->acciones[] = $accionPAM;
            $accionPAM->setLinea($this);
        }

        return $this;
    }

    public function removeAccion(AccionPAM $accionPAM): self
    {
        if ($this->acciones->contains($accionPAM)) {
            $this->acciones->removeElement($accionPAM);
            // set the owning side to null (unless already changed)
            if ($accionPAM->getLinea() === $this) {
                $accionPAM->setLinea(null);
            }
        }

        return $this;
    }

    public function getallAcciones()
    {
        /**
         * @var Collection|ArrayCollection[] $collection
         */
        $collection = new ArrayCollection();
        /**
         * @var AccionPAM $accionPAM
         */
        $accionPAM = $this->acciones;
        foreach ($accionPAM as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item->getNombre());
            }
        }

        return $collection;
    }

    public function getPAM(): ?PAM
    {
        return $this->pam;
    }

    public function setPAM(?PAM $PAM): self
    {
        $this->pam = $PAM;

        return $this;
    }
}
