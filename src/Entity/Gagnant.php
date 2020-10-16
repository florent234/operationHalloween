<?php

namespace App\Entity;

use App\Repository\GagnantRepository;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="gagnant")
 * @ORM\Entity(repositoryClass=GagnantRepository::class)
 */
class Gagnant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="integer")
     */
    private $idGagnant;



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
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;

    }
    /**
     * @return mixed
     */
    public function getIdGagnant()
    {
        return $this->idGagnant;
    }

    /**
     * @param mixed $idGagnant
     */
    public function setIdGagnant($idGagnant)
    {
        $this->idGagnant = $idGagnant;

        return $this;

    }
}
