<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilDeSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilDeSortieRepository::class)
 * @ApiResource(
    *normalizationContext = {"groups"={"profSort:read"}},
    *denormalizationContext = {"groups"={"profSort:write"}}
    , 
    *attributes = {
        *"security" = "is_granted('ROLE_ADMIN')",
        *"security_message" = "vous n'avez pas accés à cette ressource"
    *},
    *routePrefix = "/admin",
    *collectionOperations = {"get", "post"},
    *itemOperations = {"get", "put", "delete"}
 * )
 */
class ProfilDeSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profSort:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le libellé ne peut être vide")
     * @Groups({"profSort:read", "profSort:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profSort:read"})
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilDeSortie")
     * @Groups({"profSort:read", "profSort:write"})
     */
    private $apprenant;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
        $this->archive =false;
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
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setProfilDeSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilDeSortie() === $this) {
                $apprenant->setProfilDeSortie(null);
            }
        }

        return $this;
    }
}
