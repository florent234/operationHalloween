<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Table(name="tirage")
 * @ORM\Entity(repositoryClass=TirageRepository::class)
 */
class Tirage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", length=50)
     */
    private $resultat;


    /*///////////////////// GETTER AND SETTER ////////////////////*/

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * @param mixed $resultat
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

}
