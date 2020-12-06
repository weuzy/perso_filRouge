<?php

namespace App\Entity;

use App\Repository\BriefRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomBrief;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $critereDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modaliteDevaluation;

    /**
     * @ORM\Column(type="blob")
     */
    private $imagePromo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getNomBrief(): ?string
    {
        return $this->nomBrief;
    }

    public function setNomBrief(string $nomBrief): self
    {
        $this->nomBrief = $nomBrief;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getCritereDevaluation(): ?string
    {
        return $this->critereDevaluation;
    }

    public function setCritereDevaluation(string $critereDevaluation): self
    {
        $this->critereDevaluation = $critereDevaluation;

        return $this;
    }

    public function getModaliteDevaluation(): ?string
    {
        return $this->modaliteDevaluation;
    }

    public function setModaliteDevaluation(string $modaliteDevaluation): self
    {
        $this->modaliteDevaluation = $modaliteDevaluation;

        return $this;
    }

    public function getImagePromo()
    {
        return $this->imagePromo;
    }

    public function setImagePromo($imagePromo): self
    {
        $this->imagePromo = $imagePromo;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = $creatAt;

        return $this;
    }
}
