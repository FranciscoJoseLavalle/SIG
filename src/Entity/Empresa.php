<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $razonSocial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombreFantasia = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domicilio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localidad = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codigoPostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $iibb = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaInicioActividades = null;

    #[ORM\Column(nullable: true)]
    private ?int $puntoDeVenta = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $passphrase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(string $razonSocial): self
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    public function getNombreFantasia(): ?string
    {
        return $this->nombreFantasia;
    }

    public function setNombreFantasia(?string $nombreFantasia): self
    {
        $this->nombreFantasia = $nombreFantasia;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(?string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(?string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function setCuit(?string $cuit): self
    {
        $this->cuit = $cuit;

        return $this;
    }

    public function getIibb(): ?string
    {
        return $this->iibb;
    }

    public function setIibb(?string $iibb): self
    {
        $this->iibb = $iibb;

        return $this;
    }

    public function getFechaInicioActividades(): ?\DateTimeInterface
    {
        return $this->fechaInicioActividades;
    }

    public function setFechaInicioActividades(?\DateTimeInterface $fechaInicioActividades): self
    {
        $this->fechaInicioActividades = $fechaInicioActividades;

        return $this;
    }

    public function getPuntoDeVenta(): ?int
    {
        return $this->puntoDeVenta;
    }

    public function setPuntoDeVenta(?int $puntoDeVenta): self
    {
        $this->puntoDeVenta = $puntoDeVenta;

        return $this;
    }

    public function getPassphrase(): ?string
    {
        return $this->passphrase;
    }

    public function setPassphrase(?string $passphrase): self
    {
        $this->passphrase = $passphrase;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }
}
