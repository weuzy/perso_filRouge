<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeDeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeDeCompetenceRepository::class)
 * @ApiResource(
    *normalizationContext = {"groups" = {"grpCom:read"}},
    *denormalizationContext = {"groups" = {"grpCom:write"}},
    *attributes = {
        *  "security" = "is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
        *  "security_message" = " vous n'avez pas accés sur cette ressource"
    *},
    *routePrefix="/admin",
    *collectionOperations = {
            *"get"={"path"="/groupe_de_competences"},
            *"get_compet"={"path"="/grpecompetences/competences", "method"= "GET",
                            *"normalization_context" = {"groups" = {"g_compt:read"}}
                        *},
            *"getId_compet"={"path"= "/grpecompetences/{id}/competences", "method"="GET",
                            *"normalization_context" = {"groups" = {"g_compt:read"}}
                        *},
            *"post"},
    *itemOperations = {"get","put","delete"}
 * )
 */
class GroupeDeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpCom:read", "grpCom:write", "g_compt:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpCom:read", "grpCom:write", "g_compt:read", "ref:read", "refComp:read", "ref_groupCompet:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpCom:read", "grpCom:write", "g_compt:read", "ref:read", "refComp:read", "ref_groupCompet:read"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeDeCompetences", cascade={"persist"})
     * @Groups({"g_compt:read", "grpCom:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupeDeCompetences")
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiels::class, mappedBy="groupeDeCompetences",cascade={"persist"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupeDeCompetence($this);
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

    /**
     * @return Collection|Referentiels[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiels $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiels $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeDeCompetence($this);
        }

        return $this;
    }
}
