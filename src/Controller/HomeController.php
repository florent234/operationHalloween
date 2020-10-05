<?php

namespace App\Controller;


use App\Entity\Clients;
use App\Entity\Tirage;
use App\Form\ClientsType;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @throws \Exception
     */
    public function home()
    {

        $ferme = "Le jeux est fermé, revenez plus tard";
        $ouvert = "CLIQUEZ POUR COMMENCER";

        date_default_timezone_set('Europe/Paris');
        $today = date("Y-m-d H:i");

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
            ["message"=>$message, "date"=>$today, "hotesse"=>$hotesse]);
    }


    /**
     * @Route("/halloween/{id}", name="halloween")
     */
    public function halloween($id)
    {
        if($id==1){
            $nom = null;
            $genre = null;

            date_default_timezone_set('Europe/Paris');

            $heure = date ("H:i");
            $hotesse = false;
            if (date("14:00")<$heure){
                if($heure<date("14:30")){

                    $userRepo = $this->getDoctrine()->getRepository(Tirage::class);
                    $tirage = $userRepo->findAll();

                    $rand = rand(1, 10);

                    // récupérer le tableau de Tirage
                    // utiliser rand pour récupérer un numéro
                    // enregistrer le résultat dans Joueur
                    // Ajouter condition en fin de demi-heure







                }
            }
        } else {
            $userRepo = $this->getDoctrine()->getRepository(Clients::class);
            $client = $userRepo->find($id);

            $nom = strtoupper($client->getNom());
            if ($client->getGenre()==1){
                $genre="Madame";
            } else {
                $genre="Monsieur";
            }


        }

        return $this->render('halloween.html.twig',
            ["id"=>$id, "nom"=>$nom, "genre"=>$genre, "heure"=>$heure
            ]);
    }
}
