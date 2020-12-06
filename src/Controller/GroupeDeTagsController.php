<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeDeTagsController extends AbstractController
{
    private $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        
    }
   
    public function addtag(Request $request)
    {
        $data = $request -> getContent();
        $group = json_decode($data, true);
        dd($group);
    }
}