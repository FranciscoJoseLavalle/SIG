<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $razonSocial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $representante = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domicilio = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $codigoPostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombreFantasia = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $horario = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $domicilioEnvios = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $codigoPostalEnvios = null;

    #[ORM\Column(nullable: true)]
    private ?bool $habilitado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(?string $razonSocial): self
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    public function getRepresentante(): ?string
    {
        return $this->representante;
    }

    public function setRepresentante(?string $representante): self
    {
        $this->representante = $representante;

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

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(?string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getNombreFantasia(): ?string
    {
        return $this->nombreFantasia;
    }

    public function setNombreFantasia(?string $nombreFantasia): self
    {
        $this->nombreFantasia = $nombreFantasia;

        return $this;
    }

    public function getHorario(): ?string
    {
        return $this->horario;
    }

    public function setHorario(?string $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    public function getTelefono1(): ?string
    {
        return $this->telefono1;
    }

    public function setTelefono1(?string $telefono1): self
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    public function getTelefono2(): ?string
    {
        return $this->telefono2;
    }

    public function setTelefono2(?string $telefono2): self
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getDomicilioEnvios(): ?string
    {
        return $this->domicilioEnvios;
    }

    public function setDomicilioEnvios(?string $domicilioEnvios): self
    {
        $this->domicilioEnvios = $domicilioEnvios;

        return $this;
    }

    public function getCodigoPostalEnvios(): ?string
    {
        return $this->codigoPostalEnvios;
    }

    public function setCodigoPostalEnvios(?string $codigoPostalEnvios): self
    {
        $this->codigoPostalEnvios = $codigoPostalEnvios;

        return $this;
    }

    public function isHabilitado(): ?bool
    {
        return $this->habilitado;
    }

    public function setHabilitado(?bool $habilitado): self
    {
        $this->habilitado = $habilitado;

        return $this;
    }
}
