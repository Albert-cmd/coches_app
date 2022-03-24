<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Coches
 * @ORM\Table(name="coches")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CochesRepository")
 */
class Coches
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
     * @Assert\NotBlank
     */
    /**
     * @var string|null
     *
     * @ORM\Column(name="modelo", type="string", length=50, nullable=true)
     */
    private $modelo;

    /**
     *
     *
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var int|null
     *
     * @ORM\Column(name="año", type="integer", nullable=true)
     */
    private $ano;

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
     * @ORM\ManyToOne(targetEntity=Marcas::class, inversedBy="Coches")
     */
    private $Marca;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $propietario;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(?string $modelo): self
    {
        $this->modelo = $modelo;

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

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function setAno(?int $ano): self
    {
        $this->ano = $ano;

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

    public function getMarca(): ?Marcas
    {
        return $this->Marca;
    }

    public function setMarca(?Marcas $Marca): self
    {
        $this->Marca = $Marca;

        return $this;
    }

    public function getPropietario(): ?string
    {
        return $this->propietario;
    }

    public function setPropietario(string $propietario): self
    {
        $this->propietario = $propietario;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

}
