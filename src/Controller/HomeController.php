<?php

namespace App\Controller;


use App\Entity\Clients;
use App\Entity\Gagnant;
use App\Entity\Joueur;
use App\Entity\Tirage;
use DateTime;
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
    public function halloween($id, EntityManagerInterface $em)
    {
        $nom = null;
        $genre = null;
        $resultat= null;
        $notAllReady = true;
        $rand=null;
        if($id==1){

            date_default_timezone_set('Europe/Paris');

            $heure = date ("H:i");
            if (date("00:00")<$heure) {         // HEURE EN DUR
                if ($heure < date("23:59")) {        // HEURE EN DUR

                    // récupérer le tableau de Tirage
                    $userRepo = $this->getDoctrine()->getRepository(Tirage::class);
                    $tirage = $userRepo->findAll();
                    // utiliser rand pour récupérer un numéro
                    $rand = rand(0, 9);

                    // enregistrer le résultat dans Joueur
                    $joueur = new Joueur();
                    $joueur->setResultat($tirage[$rand]);
                    $joueur->setDateCreation(new DateTime());

                    $em->persist($joueur);
                    $em->flush();

                    // verification si pas de gagnant
                    $userRepo = $this->getDoctrine()->getRepository(Gagnant::class);
                    $gagnants = $userRepo->findAll();

                    foreach ($gagnants as $gagnant){
                        if($gagnant->getCreneau()=="14:00"){    // HEURE EN DUR
                            $notAllReady=false;
                        }
                    }
                    //calculer et afficher le resultat

                    if ($rand === 9 and $notAllReady) {
                        $resultat = "Vous avez GAGNÉ un bon d'achat de 20€";

                        $gagnant = new Gagnant();
                        $gagnant->setCreneau("14:00");   // HEURE EN DUR
                        $gagnant->setDateCreation(new DateTime());

                        $em->persist($gagnant);
                        $em->flush();
                    } else {
                        $resultat = "PERDU";
                    }

                    // Ajouter condition en fin de demi-heure

                 /*   if ($heure < date("23:59")) {       // HEURE EN DUR
                        $userRepo = $this->getDoctrine()->getRepository(Joueur::class);
                        $joueurs = $userRepo->findAll();
                        foreach ($joueurs as $joueur){
                            if ("23:30" < $joueur->getDateCreation()->format('H:i')) {    // HEURE EN DUR
                                if($joueur->getDateCreation()->format('H:i')<"23:59"){     // HEURE EN DUR
                                   if($joueur->getResultat()==false){
                                       $compteur=1;
                                   }
                                }
                            }
                        }

                    }*/
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
            ["id"=>$id, "nom"=>$nom, "genre"=>$genre, "heure"=>$heure, "resultat"=>$resultat
                , "rand"=>$rand , "tirages"=>$tirage
            ]);
    }
}
