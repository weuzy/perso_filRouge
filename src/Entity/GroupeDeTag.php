<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeDeTagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=GroupeDeTagRepository::class)
 * @ApiResource(
    *routePrefix = "/admin",
    *collectionOperations = {
        *"get", "post"
    *},
    *itemOperations = {
        *"get", "put", "delete"
    *},
    *normalizationContext = {"groups" = {"Grptag:read"}},
    *denormalizationContext = {"groups" = {"Grptag:write"}},
    *attributes= {
        * "security" = "is_granted('ROLE_ADMIN')",
        * "security_message" = " vous n'avez pas accés sur cette ressource"
    *}
 * )
 */
class GroupeDeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Grptag:read", "Grptag:write", "tag:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Grptag:read", "Grptag:write", "tag:read"})
     * @Assert\NotBlank(message= "le libelle du groupe de tags est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Grptag:read", "tag:read"})
     */
    private $archive;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeDeTags", cascade={"persist"})
     * @Groups({"Grptag:read", "Grptag:write"})
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this-> archive = false;
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
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        $tag -> groupeDeTag = $this;
        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
