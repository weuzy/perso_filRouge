<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
    *routePrefix = "/admin",
    *collectionOperations = {
        *"get", "post"
    *},
    *itemOperations = {
        *"get", "put", "delete"
    *},
    *normalizationContext = {"groups" = {"tag:read"}},
    *denormalizationContext = {"groups" = {"tag:write"}},
    *attributes= {
        * "security" = "is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
        * "security_message" = " vous n'avez pas accés sur cette ressource"
    *}
 * )
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"tag:read", "tag:write", "Grptag:read", "Grptag:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tag:read", "tag:write", "Grptag:read", "Grptag:write"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetence::class, inversedBy="tags")
     */
    private $groupeDeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeTag::class, mappedBy="tags")
     * @Groups({"tag:read"})
     */
    private $groupeDeTags;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"tag:read"})
     */
    private $archive;

    public function __construct()
    {
        $this->groupeDeCompetences = new ArrayCollection();
        $this->groupeDeTags = new ArrayCollection();
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

    /**
     * @return Collection|GroupeDeTag[]
     */
    public function getGroupeDeTags(): Collection
    {
        return $this->groupeDeTags;
    }

    public function addGroupeDeTag(GroupeDeTag $groupeDeTag): self
    {
        if (!$this->groupeDeTags->contains($groupeDeTag)) {
            $this->groupeDeTags[] = $groupeDeTag;
            $groupeDeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeDeTag(GroupeDeTag $groupeDeTag): self
    {
        if ($this->groupeDeTags->removeElement($groupeDeTag)) {
            $groupeDeTag->removeTag($this);
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
