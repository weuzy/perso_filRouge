<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;


/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *normalizationContext = {"groups" = {"profil:read"}},
 *denormalizationContext = {"groups" = {"profil:write"}},
 * attributes = {
 *  "security" = "is_granted('ROLE_ADMIN')",
 *  "security_message" = " vous n'avez pas accés sur cette ressource"
 * },
    routePrefix="/admin",
 *  collectionOperations = {
 *      "get"={"path"="/profils", "status"=301}, "post"
 * },
 *  itemOperations = {"get","put","delete"}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archive" : true})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read", "profil:write"})
     * @Assert\NotBlank(message = "le libelle ne peut pas être vide")
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profil:read"})
     */
    private $archive;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }

    
}
