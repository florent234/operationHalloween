<?php

namespace App\Entity;

use App\Repository\TirageRepository;
use Doctrine\ORM\Mapping as ORM;



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
    public function getId()
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
