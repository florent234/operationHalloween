<?php

namespace App\Controller;


use App\Entity\Clients;
use App\Form\ClientsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {

        $ferme = "Le jeux est fermé, revenez plus tard";
        $ouvert = "CLIQUEZ POUR COMMENCER";


        $today = date("Y-m-d H:i"); // ATTENTION 2 heure de moins ...
        $dateDebut = date("2020-10-02 08:30");
        $dateFin = date("2020-10-27 18:30");
        if ($dateDebut<$today){
            if($today<$dateFin){
                $message = $ouvert;
            } else {
                $message = $ferme;
            }
        } else {
            $message = $ferme;
        }

        // CAS OU IL Y A UNE HOTESSE
        // POUR l'instant toutes les après midi de 14h à 18h
        $heure = date ("H:i");
        $hotesse = false;
        if (date("00:00")<$heure){
            if($heure<date("23:59")){
                $hotesse = true;
            }
        }


        return $this->render('accueil.html.twig',
            ["message"=>$message, "date"=>$today, "hotesse"=>$hotesse, "null"=>1]);
    }

    /**
     * @Route("/halloween", name="halloween")
     */
    public function halloween()
    {
        // A faire un suivi entre inscription et l'arrivé sur halloween


        return $this->render('halloween.html.twig',
            []);
    }
/* /**
     * ("/halloween/{$id}", name="halloween", requirements={"id": "\d+" })
     *
    public function halloween(int $id)
    {
        // A faire un suivi entre inscription et l'arrivé sur halloween


        return $this->render('halloween.html.twig',
            ["id"=>$id]);
    }*/

}
