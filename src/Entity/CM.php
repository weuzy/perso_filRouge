<?php

namespace App\Entity;

use App\Entity\User;
use App\Repository\CMRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CMRepository::class)
 */
class CM extends User
{
   
}
