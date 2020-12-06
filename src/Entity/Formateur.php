<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
    *attributes = {
        *"security" = "is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
        *"security_message" = "vous n'avez pas accés à cette ressource",
        *"pagination_enabled" = true,
        *"pagination_items_per_page" = 3,
    *},
    *collectionOperations = {
        *"get"={"security" = "is_granted('ROLE_CM')"}
    *},
    *itemOperations= {"get", "put"}
 * )
 */
class Formateur extends User
{
    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="formateurs")
     */
    private $promo;

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
