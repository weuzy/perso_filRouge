<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserServices
{
    protected $encoder;
    protected $serializer;
    public function __construct(UserPasswordEncoderInterface $encoder, SerializerInterface $serializer)
    {
        $this -> encoder = $encoder;
        $this -> serializer = $serializer;
    }
    public function addUser(Request $request)
    {
        $user = $request -> request -> all();
        $avatar = $request -> files -> get('photo');
        $avatar = fopen($avatar -> getRealPath(), "r+");
        $user["photo"] = $avatar;
        $profil = $this -> serializer -> denormalize($user['profil'], "App\Entity\Profil");
        $profilLibelle = $profil -> getLibelle();
        $user = $this -> serializer -> denormalize($user, "App\Entity\\" . $profilLibelle);
        $password = $user -> getPassword();
        $user -> setPassword($this -> encoder -> encodePassword($user, $password))
              -> setPhoto($avatar)
              -> setArchive(0);
        return $user;
    }
    public function editUser(Request $req)
    {
        $up = $req -> getContent();
        $cut = preg_split("/form-data; /", $up);
        unset($cut[0]);
        $data =[];
        foreach ($cut as $item) {
            $cool = preg_split("/\r\n/", $item);
            array_pop($cool);
            array_pop($cool);
            $find = explode('"', $cool[0]);
            $data[$find[1]] = end($cool);
        }
        if (isset($data["photo"])) {
           $stream = fopen('php://memory', 'r+');
           fwrite($stream, $data['photo']);
           rewind($stream);
           $data['photo'] = $stream;
        }
        return $data;
    }
}