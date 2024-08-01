<?php

namespace App\Entity;

use App\Repository\PAMRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PAMRepository::class)
 */
class PAM
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
     * @ORM\OneToMany(targetEntity="App\Entity\LineaEstrategica", mappedBy="pam", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $lineas;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $resultados_esperados;

    /**
     * @ORM\Column(type="text")
     */
    private $cuantitativos;

    /**
     * @ORM\Column(type="text")
     */
    private $cualitativos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    public function __construct()
    {
        $this->lineas = new ArrayCollection();
        $this->activo = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    /**
     * @return Collection|LineaEstrategica[]
     */
    public function getLineas(): Collection
    {
        /**
         * @var Collection|LineaEstrategica[] $collection
         */
        $collection = new ArrayCollection();

        /**
         * @var LineaEstrategica $lineas
         */
        $lineas = $this->lineas;
        foreach ($lineas as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item);
            }
        }
        return $collection;
    }

    public function addLinea(LineaEstrategica $lineaEstrategica): self
    {
        if (!$this->lineas->contains($lineaEstrategica)) {
            $this->lineas[] = $lineaEstrategica;
            $lineaEstrategica->setPAM($this);
        }

        return $this;
    }

    public function removeLinea(LineaEstrategica $lineaEstrategica): self
    {
        if ($this->lineas->contains($lineaEstrategica)) {
            $this->lineas->removeElement($lineaEstrategica);
            // set the owning side to null (unless already changed)
            if ($lineaEstrategica->getPAM() === $this) {
                $lineaEstrategica->setPAM(null);
            }
        }

        return $this;
    }

    public function getallLineas()
    {
        /**
         * @var Collection|ArrayCollection[] $collection
         */
        $collection = new ArrayCollection();
        /**
         * @var LineaEstrategica $linea
         */
        $linea = $this->lineas;
        foreach ($linea as $item)
        {
            if ($item->getActivo()==1)
            {
                $collection->add($item->getNombre());
            }
        }

        return $collection;
    }

    public function getResultadosEsperados(): ?string
    {
        return $this->resultados_esperados;
    }

    public function setResultadosEsperados(string $resultados): self
    {
        $this->resultados_esperados = $resultados;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCuantitativos(): ?string
    {
        return $this->cuantitativos;
    }

    public function setCuantitativos(string $cuantitativos): self
    {
        $this->cuantitativos = $cuantitativos;

        return $this;
    }

    public function getCualitativos(): ?string
    {
        return $this->cualitativos;
    }

    public function setCualitativos(string $cualitativos): self
    {
        $this->cualitativos = $cualitativos;

        return $this;
    }
}
