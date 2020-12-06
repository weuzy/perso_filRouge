<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
    *routePrefix = "/admin",
    *collectionOperations = {"get", "post",
            *"get_grpApprenant"={"path"="/groupes/apprenants", "method"="GET",
                    *"normalization_context"={"groups"={"grpAppr:read"}}}
        *},
    *itemOperations = {"get", "put", "delete"},
    *attributes = {
        *"security" = "is_granted('ROLE_ADMIN') or  is_granted('ROLE_FORMATEUR')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"normalization_context" = {"groups"={"grp:read"}},
        *"denormalization_context" = {"groups"={"grp:write"}}
    *}
 * )
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"prom:read", "grp:read", "grp:write", "grpAppr:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "grp:read", "grp:write", "grpAppr:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "grp:read", "grp:write", "grpAppr:read"})
     */
    private $periode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"prom:read", "grp:read", "grp:write", "grpAppr:read"})
     */
    private $createAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"prom:read", "grp:read", "grpAppr:read"})
     */
    private $archive;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     * @Groups({"grp:read"})
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="groupe", cascade={"persist"})
     * @Groups({"grp:read", "grp:write", "grpAppr:read"})
     */
    private $apprenants;

    /**
     * @ORM\OneToOne(targetEntity=Formateur::class, cascade={"persist", "remove"})
     * @Groups({"grp:read", "grp:write"})
     */
    private $formateur;

    public function __construct()
    {
        $this->archive = false;
        $this->apprenants = new ArrayCollection();
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

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

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

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setGroupe($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getGroupe() === $this) {
                $apprenant->setGroupe(null);
            }
        }

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }
}
