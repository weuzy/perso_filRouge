<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
    *attributes = {
        *"security" = "is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT')",
        *"security_message" = "vous n'ave pas accés à cette ressource",
        *"pagination_enabled" = true,
        *"pagination_items_per_page" = 2
    },
    *collectionOperations = {
      *"add_apprenant" ={ 
        *"method" = "post",
        *"route_name" = "addApprenant_byFormateur",
        *"controller" = UserController::class
      *},
      *"get"={"security" = "is_granted('ROLE_CM')"}
    *},
    *itemOperations = {"get"={"security" = "is_granted('ROLE_CM')"}, "put"}
 * )
 */
class Apprenant extends User
{

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="l'adresse ne peut pas être vide")
     * @Groups({"prom:read", "profSort:read", "profSort:write", "grp:read", "grpAppr:read"})
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilDeSortie::class, inversedBy="apprenant")
     */
    private $profilDeSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="apprenants")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="apprenants")
     */
    private $promo;

    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getProfilDeSortie(): ?ProfilDeSortie
    {
        return $this->profilDeSortie;
    }

    public function setProfilDeSortie(?ProfilDeSortie $profilDeSortie): self
    {
        $this->profilDeSortie = $profilDeSortie;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

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
}
