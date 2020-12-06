<?php

namespace App\Controller;

use App\Repository\ReferentielsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ReferentielController extends AbstractController
{
    /** 
     * @Route(
     *      path = "api/admin/referentiels/{id}/grpecompetences/{iD}",
     *      methods = "GET",
     *      name = "ref_groupCompet"
     * )
    */
   public function GetReferentienlGroupeDeCompetence($id, $iD, ReferentielsRepository $ref)
   {
        $data = $ref -> findOneByrefGRpCompetence($id, $iD);
       // dd($data);
        if ($data) {
            return $this->json($data, Response::HTTP_OK, [], ['groups' => 'ref_groupCompet:read']);
        }
        return $this->json('référentiel lié à cette groupe introuvable', Response::HTTP_BAD_REQUEST);
   }
}
