<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compt:read", "compt:write", "grpCom:write", "refComp:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read"})
     */
    private $criterDevaluation;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveaux")
     */
    private $competences;

    /**
     * @ORM\OneToMany(targetEntity=Actions::class, mappedBy="niveau")
     */
    private $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getCriterDevaluation(): ?string
    {
        return $this->criterDevaluation;
    }

    public function setCriterDevaluation(string $criterDevaluation): self
    {
        $this->criterDevaluation = $criterDevaluation;

        return $this;
    }

    public function getCompetences(): ?Competences
    {
        return $this->competences;
    }

    public function setCompetences(?Competences $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    /**
     * @return Collection|Actions[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Actions $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setNiveau($this);
        }

        return $this;
    }

    public function removeAction(Actions $action): self
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getNiveau() === $this) {
                $action->setNiveau(null);
            }
        }

        return $this;
    }
}
