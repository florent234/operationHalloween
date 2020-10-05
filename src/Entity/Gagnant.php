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
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string")
     */
    private $creneau;



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
    public function getCreneau()
    {
        return $this->creneau;
    }

    /**
     * @param mixed $creneau
     */
    public function setCreneau($creneau)
    {
        $this->creneau = $creneau;

        return $this;

    }
}
