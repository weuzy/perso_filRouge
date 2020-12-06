<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type",type="string")
 * @ORM\DiscriminatorMap({"admin" = "Admin", "apprenant" = "Apprenant", "formateur" = "Formateur", "cm" = "CM", "user" = "User"})
 * @UniqueEntity(
    *fields = {"username", "email", "telephone"},
    *message = "l'email ou le username est est déjà utilisé, veuillez choisir un autre" 
 * )
 * @ApiResource(
    *normalizationContext = {"groups" = {"admin:read"}}, 
    *attributes = {
        * "security" = "is_granted('ROLE_ADMIN')",
        * "security_message" = "vous n'avez pas accés à cette ressource",
        
 * },
        routePrefix = "/admin",
    *collectionOperations = {"get",
        *"add_user" = {
            *"method" = "POST",
            *"route_name" = "add_user"
    * }
    *},
    *itemOperations = {"get",
    *"editUserByAdmin" = {
        *"deserialize" = false,
        *"method" = "PUT",
        *"route_name" = "editUserByAdmin"},  
    *"delete"}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archive" : true})

 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:write", "grp:read", "grpAppr:read"})

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message = "le username ne peut pas être vide")
     * @Groups({"prom:read", "admin:read", "admin:write" , "grp:read", "grpAppr:read"})
     */
    private $username;

    
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "le mot de passe ne peut pas être vide")
     * @Groups({"admin:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le prénom ne peut pas être vide")
     * @Assert\Regex(
     * pattern = "/^[A-Z][a-z]+$/",
     * message = "le prénom commence par un majuscule"
     * )
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le nom ne peut pas être vide")
     * @Assert\Regex(
     * pattern = "/^[A-Z]+$/",
     * message = "le nom est en majuscule"
     * )
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "l'email ne peut pas être vide")
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le numéro de téléphone ne peut pas être vide")
     
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "le genre ne peut pas être vide")
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $genre;

    /**
     * @ORM\Column(type="blob")
     * @Assert\NotBlank(message = "la photo ne peut pas être vide")
     * @Groups({"prom:read", "admin:read", "admin:write", "grp:read", "grpAppr:read"})
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"prom:read", "admin:read", "grpAppr:read"})
     */
    private $archive;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @Groups({"admin:read"})
     */
    private $profil;

    public function __construct()
    {
        $this->archive =false;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this -> profil -> getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPhoto()
    {
        return base64_encode(stream_get_contents($this->photo));
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

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

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    
}
