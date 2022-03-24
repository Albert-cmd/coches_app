<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Marcas
 *
 * @ORM\Table(name="marcas")
 * @ORM\Entity
 * @ORM\Entity (repositoryClass="App\Repository\MarcasRepository")
 */
class Marcas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_alta", type="datetime", nullable=true)
     */
    private $fechaAlta;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaModificacion = 'CURRENT_TIMESTAMP';

    /**
     * @ORM\OneToMany(targetEntity=Coches::class, mappedBy="Marca")
     */
    private $Coches;

    public function __construct()
    {
        $this->Coches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(?bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getFechaAlta(): ?\DateTimeInterface
    {
        return $this->fechaAlta;
    }

    public function setFechaAlta(?\DateTimeInterface $fechaAlta): self
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    public function getFechaModificacion(): ?\DateTimeInterface
    {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion(?\DateTimeInterface $fechaModificacion): self
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * @return Collection<int, Coches>
     */
    public function getCoches(): Collection
    {
        return $this->Coches;
    }

    public function addCoch(Coches $coch): self
    {
        if (!$this->Coches->contains($coch)) {
            $this->Coches[] = $coch;
            $coch->setMarca($this);
        }

        return $this;
    }

    public function removeCoch(Coches $coch): self
    {
        if ($this->Coches->removeElement($coch)) {
            // set the owning side to null (unless already changed)
            if ($coch->getMarca() === $this) {
                $coch->setMarca(null);
            }
        }

        return $this;
    }




}
