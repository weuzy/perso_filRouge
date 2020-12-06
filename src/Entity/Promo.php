<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
    *routePrefix = "/admin",
    *collectionOperations = {"get", "post",
            *"principal"={"path"="/promo/principal", "method"="GET", 
                *"normalization_context"={"groups"={"princ:read"}}}
        *},
    *itemOperations = {"get", "put", "delete"},
    *attributes = {
        *"security" = "is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
        *"security_message" = "vous n'avez accés à cette ressource",
        *"normalization_context" = {"groups" = {"prom:read"}},
        *"denormalization_context" = {"groups" = {"prom:write"}}
    *}
 * )
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"prom:read", "princ:read"})
     */
    private $archive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $choixDeLaFabrique;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $endAt;

    /**
     * @ORM\OneToMany(targetEntity=Referentiels::class, mappedBy="promo")
     */
    private $referentiels;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"prom:read", "prom:write"})
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=Formateur::class, mappedBy="promo")
     * @Groups({"prom:read", "prom:write", "princ:read"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo")
     * @Groups({"princ:read"})
     */
    private $apprenants;

    public function __construct()
    {
        $this->archive = false;
        $this->referentiels = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getAvatar()
    {
        return base64_encode(stream_get_contents($this->avatar));
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

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

    public function getReferenceAgate(): ?string
    {
        return $this->referenceAgate;
    }

    public function setReferenceAgate(string $referenceAgate): self
    {
        $this->referenceAgate = $referenceAgate;

        return $this;
    }

    public function getChoixDeLaFabrique(): ?string
    {
        return $this->choixDeLaFabrique;
    }

    public function setChoixDeLaFabrique(string $choixDeLaFabrique): self
    {
        $this->choixDeLaFabrique = $choixDeLaFabrique;

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

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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
            $referentiel->setPromo($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiels $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            // set the owning side to null (unless already changed)
            if ($referentiel->getPromo() === $this) {
                $referentiel->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
            $formateur->setPromo($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->removeElement($formateur)) {
            // set the owning side to null (unless already changed)
            if ($formateur->getPromo() === $this) {
                $formateur->setPromo(null);
            }
        }

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
            $apprenant->setPromo($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromo() === $this) {
                $apprenant->setPromo(null);
            }
        }

        return $this;
    }
}
