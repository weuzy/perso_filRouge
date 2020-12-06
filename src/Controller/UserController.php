<?php

namespace App\Controller;

use App\Services\UserServices;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as TestResponse;
use App\Repository\ProfilRepository;

class UserController extends AbstractController
{
    protected $repo;
    protected $repoProfil;
    public function __construct(UserRepository $repo, ProfilRepository $repoProfil)
    {
        $this -> repoUser = $repo;
        $this -> repoProfil = $repoProfil;
    }
    /**
     * @Route("/api/admin/users", name="add_user", methods="post"),
     * @Route("/api/apprenants", name="addApprenant_byFormateur", methods="post")
     */
    public function addedUserByAdmin(Request $request, UserServices $_userServices, EntityManagerInterface $manager)
    {
        $user = $_userServices -> addUser($request);
        $manager -> persist($user);
        $manager -> flush();
        return $this -> json("un utilisateur a été créé avec success", Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/admin/users/{id}", name="editUserByAdmin", methods="put")
     */
   public function editUserByAdmin(int $id, Request $request, UserServices $_userServices, EntityManagerInterface $manager)
   {
       $user = $this -> repoUser -> find($id);
       $editUser = $_userServices -> editUser($request);
       foreach ($editUser as $item => $value) {
           if ($item !== "profil") {
               $setProperty = 'set'.ucfirst($item);
               $user -> $setProperty($value);
            }
        }
       $manager -> flush();
       return $this -> json("Utilisateur modifié avec success", Response::HTTP_OK);

   }
}
