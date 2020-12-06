<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 * @ApiResource(
    *routePrefix = "/admin", 
    * normalizationContext= {"groups"= {"compt:read"}},
    * denormalizationContext= {"groups"= {"compt:write"}},
    * attributes= {
        *"security" = "is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"collectionOperations" = {"post", "get"},
        *"itemOperations" = {"get", "put", "delete"}
    *}
 * )
 */
class Competences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read", "ref_groupCompet:read"})

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read", "ref_groupCompet:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read", "ref_groupCompet:read"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetence::class, mappedBy="competences", cascade={"persist"})
     */
    private $groupeDeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competences", cascade={"persist"})
     * @Groups({"compt:read", "compt:write", "grpCom:write", "g_compt:read", "refComp:read"})
     */
    private $niveaux;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    public function __construct()
    {
        $this->groupeDeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
        $this->archive = false;
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|GroupeDeCompetence[]
     */
    public function getGroupeDeCompetences(): Collection
    {
        return $this->groupeDeCompetences;
    }

    public function addGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if (!$this->groupeDeCompetences->contains($groupeDeCompetence)) {
            $this->groupeDeCompetences[] = $groupeDeCompetence;
            $groupeDeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if ($this->groupeDeCompetences->removeElement($groupeDeCompetence)) {
            $groupeDeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetences($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetences() === $this) {
                $niveau->setCompetences(null);
            }
        }

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
}
