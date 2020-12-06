<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ReferentielsRepository::class)
 * @ApiResource(
    * routePrefix= "/admin",
    * collectionOperations = {"get", "post",
            *"get_RefGrpCompt" = {"path"="/referentiels/grpecompetences", "method"="GET",
                    *"normalization_context"={"groups"={"refComp:read"}}}
        *},
    * itemOperations = {"get", "put", "delete",
                    *"get_RefGrpCompt" = {"path"="/referentiels/{id}/grpecompetences", "method"="GET",
                            *"normalization_context"={"groups"={"refComp:read"}}},
                    *"ref_groupCompet"={"method"="GET", "route_name"="ref_groupCompet"}
        *},
    * attributes = {
        *"security" = "is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"normalization_context" = {"groups" = {"ref:read"}},
        *"denormalization_context" = {"groups" = {"ref:write"}}
    *} 
 * )
 */
class Referentiels
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "princ:read", "ref_groupCompet:read"})
     * @Assert\NotBlank(message= "le libellé est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     * @Assert\NotBlank(message= "la présentation est obligatoire")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $critereDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $critereDadmission;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetence::class, inversedBy="referentiels",cascade={"persist"})
     * @Groups({"ref:read", "ref:write", "refComp:read", "ref_groupCompet:read"})
     */
    private $groupeDeCompetences;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="referentiels")
     */
    private $promo;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"ref:read"})
     */
    private $archive;

    public function __construct()
    {
        $this->groupeDeCompetences = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

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

    public function getCritereDadmission(): ?string
    {
        return $this->critereDadmission;
    }

    public function setCritereDadmission(string $critereDadmission): self
    {
        $this->critereDadmission = $critereDadmission;

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
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        $this->groupeDeCompetences->removeElement($groupeDeCompetence);

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

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
