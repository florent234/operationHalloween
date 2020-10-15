<?php

namespace App\Controller;


use App\Entity\Clients;
use App\Entity\Gagnant;
use App\Entity\Joueur;
use App\Entity\Tirage;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;


class HomeController extends AbstractController
{
    // CAS CLIENT TOUTES LA JOURNEE //////////////////////

    /**
     * @Route("/", name="home")
     * @throws Exception
     */
    public function home()
    {
        $hotesse = false;
        $ferme = "Le jeux est fermé, revenez plus tard";
        $ouvert = "CLIQUEZ POUR COMMENCER";

        date_default_timezone_set('Europe/Paris');
        $today = date("Y-m-d H:i");

        $dateDebut = date("2020-10-02 08:30");  ///////// DATE DEBUT CONCOURS
        $dateFin = date("2020-10-27 21:00");    /////// DATE DE FIN DU CONCOURS

        if ($dateDebut<$today){
            if($today<$dateFin){
                $message = $ouvert;
            } else {
                $message = $ferme;
            }
        } else {
            $message = $ferme;
        }

        return $this->render('accueil.html.twig',
            ["message"=>$message, "date"=>$today, "hotesse"=>$hotesse]);
    }

    // CAS CLIENT TOUTES LA JOURNEE //////////////////////

    /**
     * @Route("/halloween/{id}", name="halloween")
     * @param $id
     * @return Response
     */
    public function halloween($id)
    {
        date_default_timezone_set('Europe/Paris');

        $nom = null;
        $genre = null;
        $rand=null;

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $client = $userRepo->find($id);

        $nom = strtoupper($client->getNom());
        if ($client->getGenre()==1){
            $genre="Madame";
        } else {
            $genre="Monsieur";
        }

        return $this->render('halloween.html.twig',
            ["id"=>$id, "nom"=>$nom, "genre"=>$genre
            ]);
    }

    // CAS HOTESSE JUSTE DE 14H A 18H /////////////////////////////////////////

    /**
     * @Route("/jeuxHalloween/", name="jeuxHalloween")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function jeuxHalloween(EntityManagerInterface $em )
    {
        $heure=null;
        $tirage=null;
        $rand =null;

        date_default_timezone_set('Europe/Paris');
        $heure = date ("H");
        $min = date ("i");
        $today = date("Y-m-d H:i");

        /* $dateDebut1 = date("2020-10-24 14:00");
        $dateFin1 = date("2020-10-24 18:00");

        $dateDebut2 = date("2020-10-28 14:00");
        $dateFin2 = date("2020-10-28 18:00");

        $dateDebut3 = date("2020-10-30 14:00");
        $dateFin3 = date("2020-10-30 18:00");

        $dateDebut4 = date("2020-10-31 14:00");
        $dateFin4 = date("2020-10-31 18:30"); */

        /////////////////////////////////////////  V   TEST    V    ////////////////////////////////////////////////////

        $dateDebut1 = date("2020-10-15 10:00");
        $dateFin1 = date("2020-10-15 18:00");

        $dateDebut2 = date("2020-10-16 14:00");
        $dateFin2 = date("2020-10-16 18:00");

        $dateDebut3 = date("2020-10-17 14:00");
        $dateFin3 = date("2020-10-17 18:00");

        $dateDebut4 = date("2020-10-13 14:00"); ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE
        $dateFin4 = date("2020-10-13 18:00");  ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE

        ////////////////////////////////  ^   TEST    ^  /////////////////////////////////////////////////////////


        if ($dateDebut1<$today & $today<$dateFin1 || $dateDebut2<$today & $today<$dateFin2 || $dateDebut3<$today &  $today<$dateFin3  || $dateDebut4<$today & $today<$dateFin4){

            $resultat = HomeController::mecanique(new DateTime('09:44'), new DateTime('17:30'), "/operationHalloween/public/photos/bon_achat/BODY_MINUTE.png",$em , -1);    //////// JUSTE POUR TESTER ///////////
            /////////////////////////////////////////  V   TEST    V    ////////////////////////////////////////////////////

            if ($today == "2020-10-15") {
                $resultat = "photos/bon_achat/PERDU.png";
            }
            if ($today == "2020-10-17") {
                $resultat = HomeController::mecanique2($heure, $em, $min);
            }
            if ($today == "2020-10-14") {
                $resultat = HomeController::mecanique1($heure, $em, $min);
            }
            if ($today == "2020-10-16") {
                $resultat = HomeController::mecanique1($heure, $em, $min);
            }
            ////////////////////////////////  ^   TEST    ^  /////////////////////////////////////////////////////////

            if ($today == "2020-10-24") {
                $resultat = HomeController::mecanique2($heure, $em, $min);
            }
            if ($today == "2020-10-31") {
                $resultat = HomeController::mecanique1($heure, $em, $min);
            }
            if ($today == "2020-10-28") {
                $resultat = HomeController::mecanique2($heure, $em, $min);
            }
            if ($today == "2020-10-30") {
                $resultat = HomeController::mecanique2($heure, $em, $min);
            }

        } else {
            $resultat ="Le jeux est ouvert le 24, 28, 30 et 31 octobre de 14h à 18h, à bientôt";
        }

        return $this->render('halloween2.html.twig',
            ["id"=>1,"heure"=>$heure, "resultat"=>$resultat
                , "rand"=>$rand , "tirages"=>$tirage
            ]);
    }

    public function mecanique1($heure, $em, $min){
        switch($heure){
            case $heure == 14 & 00<=$min & $min<30 : $resultat = HomeController::mecanique( new DateTime('14:00'), new DateTime("14:30"), "photos/bon_achat/MAISONS_MONDE.png",$em, 0 ); break;
            case $heure ==14 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new DateTime("14:30"), new DateTime("15:00"), "photos/bon_achat/CENTRAKOR.png",$em, 1); break;
            case $heure ==15 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new DateTime("15:00"), new DateTime("15:30"), "photos/bon_achat/FRANCK_P.png",$em, 2 ); break;
            case $heure ==15 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new DateTime("15:30"), new DateTime("16:00"), "photos/bon_achat/MICRO.png",$em, 3 ); break;
            case $heure == 16 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new DateTime("16:00"), new DateTime("16:30"), "photos/bon_achat/HEXA.png",$em , 4); break;
            case $heure ==16 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new DateTime("16:30"), new DateTime("17:00"), "photos/bon_achat/NOELIE.png",$em, 5 ); break;
            case $heure == 17 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new DateTime("17:00"), new DateTime("17:30"), "photos/bon_achat/BODY_MINUTE.png",$em, 6 ); break;
            case $heure ==17 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new DateTime("17:30"), new DateTime("18:00"), "photos/bon_achat/OLIPHIL.png",$em, 7 ); break;
        }
        return $resultat;
    }
    public function mecanique2($heure, $em, $min){
        switch($heure){
            case $heure == 14 & 00<=$min & $min<34 : $resultat = HomeController::mecanique(new DateTime("14:00"), new DateTime("14:34"), "photos/bon_achat/BODY_MINUTE.png",$em, 0 ); break;
            case $heure ==14 & 34<=$min || $heure ==15 & $min<9 : $resultat = HomeController::mecanique(new DateTime("14:34"), new DateTime("15:09"), "photos/bon_achat/LANDREAU.png",$em, 1 ); break;
            case $heure ==15 & 9<=$min & $min<43 : $resultat = HomeController::mecanique(new DateTime("15:09"), new DateTime("15:43"), "photos/bon_achat/CACHE_CACHE.png",$em, 2 ); break;
            case $heure ==15 & 43<=$min || $heure ==16 & $min<17 : $resultat = HomeController::mecanique(new DateTime("15:43"), new DateTime("16:17") , "photos/bon_achat/MAISONS_MONDE.png",$em, 3 ); break;
            case $heure == 16 & 17<=$min & $min<51 : $resultat = HomeController::mecanique(new DateTime("16:17"), new DateTime("16:51"), "photos/bon_achat/NOCIBE.png",$em, 4 ); break;
            case $heure ==16 & 51<=$min || $heure ==17 & $min<26 : $resultat = HomeController::mecanique(new DateTime("16:51"), new DateTime("17:26"), "photos/bon_achat/VISUAL.png",$em, 5 ); break;
            case $heure == 17 & 26<=$min & $min<=60 : $resultat = HomeController::mecanique(new DateTime("17:26"), new DateTime("18:00"), "photos/bon_achat/GRAIN_DEMALICE.png",$em, 6 ); break;
        }
        return $resultat;
    }
    public function mecanique(DateTime $heureDepart, DateTime $heureArrive, String $bonAchat,  $em, int $nbr) : string{
        $notAllReady = true;
        $rand=null;

        date_default_timezone_set('Europe/Paris');

        $now = new DateTime("Y/m/d");    /////// DATE DE FIN DU CONCOURS




        // récupérer le tableau de Tirage
        $userRepo = $this->getDoctrine()->getRepository(Tirage::class);
        $tirage = $userRepo->findAll();

        // verification si pas de gagnant
        $userRepo = $this->getDoctrine()->getRepository(Gagnant::class);
        $gagnants = $userRepo->findAll();

        foreach ($gagnants as $gagnant){
            if($gagnant->getCreneau()==$heureDepart){
                $notAllReady=false;
            }
        }




        // CAS OU IL N Y A PAS DE GAGNANT ENCORE SUR LE CRENEAU HORRAIRE
        if ($notAllReady) {
            // utiliser rand pour récupérer un numéro
            $rand = rand(0, 9);

            // enregistrer le résultat dans Joueur
            $joueur = new Joueur();
            $joueur->setResultat($tirage[$rand]);
            $joueur->setDateCreation(new DateTime("now"));

            $em->persist($joueur);
            $em->flush();

            //calculer et afficher le resultat

            if ($rand === 9) {
                $resultat = $bonAchat;

                $gagnant = new Gagnant();

                $gagnant->setCreneau($heureDepart->format('H:i'));
                $gagnant->setDateCreation(new DateTime());

                $em->persist($gagnant);
                $em->flush();

            } else {
                $resultat = "photos/bon_achat/PERDU.png";
            }

            // Faire gagner si dans les 5 derniers minutes aucun gagnant

            $diff = $now->diff($heureArrive);
            $nb_minute = $diff->i;

            if($nb_minute<5){
                $resultat = $bonAchat;

                $gagnant = new Gagnant();
                $gagnant->setCreneau($heureDepart);
                $gagnant->setDateCreation(new DateTime());

                $em->persist($gagnant);
                $em->flush();
            }
        } else {
            $resultat = "photos/bon_achat/PERDU.png";
        }

        // Faire gagner si sur le précédent creanau aucun gagnant
        $userRepo = $this->getDoctrine()->getRepository(Gagnant::class);
        $gagnant = $userRepo->findByDate($now);

        if(sizeof($gagnant) < $nbr){
            $resultat = $bonAchat;
            $gagnant = new Gagnant();
            $gagnant->setCreneau($heureDepart - 1800);
            $gagnant->setDateCreation(new DateTime());

            $em->persist($gagnant);
            $em->flush();
        }
        return $resultat;
    }

    /**
     * @Route("/admin", name="admin");
     */
    public function admin()
    {

        return $this->render('nav/administrateur.html.twig', [
        ]);
    }
}


