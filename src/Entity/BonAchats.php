<?php

namespace App\Entity;

use App\Repository\BonachatsRepository;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="bonachats")
 * @ORM\Entity(repositoryClass=BonachatsRepository::class)
 */
class BonAchats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $bonachat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gagnant;

    /**
     * @ORM\Column(type="integer")
     */
    private $jour;

    /**
     * @ORM\Column(type="integer")
     */
    private $heure;

    /**
     * @ORM\Column(type="integer")
     */
    private $min;


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
    public function getBonachat()
    {
        return $this->bonachat;
    }
    /**
     * @return mixed
     */
    public function getGagnant()
    {
        return $this->gagnant;
    }
    /**
     * @return mixed
     */
    public function getJour()
    {
        return $this->jour;
    }
    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }
    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->min;
    }


    /**
     * @param mixed $gagnant
     */
    public function setGagnant($gagnant)
    {
        $this->gagnant = $gagnant;

        return $this;
    }
    /**
     * @param mixed $jour
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }



}
