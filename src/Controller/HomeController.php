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


    // CAS CLIENT TOUTES LA JOURNEE //////////////////////

    /**
     * @Route("/", name="home")
     * @throws \Exception
     */
    public function home()
    {
        $hotesse = false;
        $ferme = "Le jeux est fermé, revenez plus tard";
        $ouvert = "CLIQUEZ POUR COMMENCER";

        date_default_timezone_set('Europe/Paris');
        $today = date("Y-m-d H:i");

        $dateDebut = date("2020-10-02 08:30");  ///////// DATE DEBUT CONCOURS
        $dateFin = date("2020-10-27 18:30");    /////// DATE DE FIN DU CONCOURS

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

    // CAS HOTESSE JUSTE DE 14H A 18H /////////////////////////////////////////
    /**
     * @Route("/accueilHalloween", name="accueilHalloween")
     */
    public function accueilHalloween()
    {
        $ferme = "Le jeux est fermé, revenez plus tard";
        $ouvert = "CLIQUEZ POUR COMMENCER";

        date_default_timezone_set('Europe/Paris');
        $today = date("Y-m-d H:i");

        $dateDebut1 = date("2020-10-24 14:00");
        $dateFin1 = date("2020-10-24 18:00");

        $dateDebut2 = date("2020-10-28 14:00");
        $dateFin2 = date("2020-10-28 18:00");

        $dateDebut3 = date("2020-10-30 14:00");
        $dateFin3 = date("2020-10-30 18:00");

        $dateDebut4 = date("2020-10-02 08:30"); ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE
        $dateFin4 = date("2020-10-27 18:30");  ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE

        if ($dateDebut1<$today || $dateDebut2<$today || $dateDebut3<$today || $dateDebut4<$today){
            if($today<$dateFin1 || $today<$dateFin2 || $today<$dateFin3 || $today<$dateFin4){
                $message = $ouvert;
                $hotesse = true;
            } else {
                $message = $ferme;
                $hotesse = false;
            }
        } else {
            $message = $ferme;
            $hotesse = false;
        }

        return $this->render('accueil.html.twig',
            ["message"=>$message, "hotesse"=>$hotesse]);
    }

    // CAS CLIENT TOUTES LA JOURNEE //////////////////////
    /**
     * @Route("/halloween/{id}", name="halloween")
     */
    public function halloween($id)
    {
        $nom = null;
        $genre = null;
        $rand=null;

        date_default_timezone_set('Europe/Paris');

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
        $resultat ="null";
        $tirage=null;
        $rand =null;

        date_default_timezone_set('Europe/Paris');
        $today = date("Y-m-d");
        $heure = date ("H");
        $min = date ("i");

        $resultat = HomeController::mecanique(new \DateTime('11:00'), new \DateTime('14:30'),$em );    //////// JUSTE POUR TESTER ///////////

        if($today=="2020-10-24" || $today=="2020-10-31"){
            switch($heure){
                case $heure == 14 & 00<=$min & $min<30 : $resultat = HomeController::mecanique( new \DateTime('14:00'), new \DateTime("14:30"),$em ); break;
                case $heure ==14 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new \DateTime("14:30"), new \DateTime("15:00"),$em ); break;
                case $heure ==15 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new \DateTime("15:00"), new \DateTime("15:30"),$em ); break;
                case $heure ==15 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new \DateTime("15:30"), new \DateTime("16:00"),$em ); break;
                case $heure == 16 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new \DateTime("16:00"), new \DateTime("16:30"),$em ); break;
                case $heure ==16 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new \DateTime("16:30"), new \DateTime("17:00"),$em ); break;
                case $heure == 17 & 00<=$min & $min<30 : $resultat = HomeController::mecanique(new \DateTime("17:00"), new \DateTime("17:30"),$em ); break;
                case $heure ==17 & 30<=$min & $min<60 : $resultat = HomeController::mecanique(new \DateTime("17:30"), new \DateTime("18:00"),$em ); break;
            }
        }
        if($today=="2020-10-28" || $today=="2020-10-30"){
            switch($heure){
                case $heure == 14 & 00<=$min & $min<34 : $resultat = HomeController::mecanique(new \DateTime("14:00"), new \DateTime("14:34"),$em ); break;
                case $heure ==14 & 34<=$min || $heure ==15 & $min<9 : $resultat = HomeController::mecanique(new \DateTime("14:34"), new \DateTime("15:09"),$em ); break;
                case $heure ==15 & 9<=$min & $min<43 : $resultat = HomeController::mecanique(new \DateTime("15:09"), new \DateTime("15:43"),$em ); break;
                case $heure ==15 & 43<=$min || $heure ==16 & $min<17 : $resultat = HomeController::mecanique(new \DateTime("15:43"), new \DateTime("16:17"),$em ); break;
                case $heure == 16 & 17<=$min & $min<51 : $resultat = HomeController::mecanique(new \DateTime("16:17"), new \DateTime("16:51"),$em ); break;
                case $heure ==16 & 51<=$min || $heure ==17 & $min<26 : $resultat = HomeController::mecanique(new \DateTime("16:51"), new \DateTime("17:26"),$em ); break;
                case $heure == 17 & 26<=$min & $min<=60 : $resultat = HomeController::mecanique(new \DateTime("17:26"), new \DateTime("18:00"),$em ); break;
            }
        }

        return $this->render('halloween.html.twig',
            ["id"=>1,"heure"=>$heure, "resultat"=>$resultat
                , "rand"=>$rand , "tirages"=>$tirage
            ]);
    }
    public function mecanique(DateTime $heureDepart, DateTime $heureArrive,  $em) : string{
        $notAllReady = true;
        $rand=null;


        $now = new \DateTime("now");


        $diff = $heureArrive->diff($now);
        $nb_jours = $diff->d;






        date_default_timezone_set('Europe/Paris');

        // récupérer le tableau de Tirage
        $userRepo = $this->getDoctrine()->getRepository(Tirage::class);
        $tirage = $userRepo->findAll();

        // verification si pas de gagnant
        $userRepo = $this->getDoctrine()->getRepository(Gagnant::class);
        $gagnants = $userRepo->findAll();

        foreach ($gagnants as $gagnant){
            if($gagnant->getCreneau()==$heureDepart){    // HEURE EN DUR
                $notAllReady=false;
            }
        }
        // CAS OU IL N Y A PAS DE GAGNANT SUR LE CRENEAU HORRAIRE
        if ($notAllReady) {
            // utiliser rand pour récupérer un numéro
            $rand = rand(0, 9);

            // enregistrer le résultat dans Joueur
            $joueur = new Joueur();
            $joueur->setResultat($tirage[$rand]);
            $joueur->setDateCreation(new \DateTime("now"));

            $em->persist($joueur);
            $em->flush();

            //calculer et afficher le resultat

            if ($rand === 9 and $notAllReady) {
                $resultat = "Vous avez GAGNÉ un bon d'achat de 20€";

                $gagnant = new Gagnant();

                $gagnant->setCreneau($heureDepart->format('H:i'));   // HEURE EN DUR
                $gagnant->setDateCreation(new \DateTime());

                $em->persist($gagnant);
                $em->flush();

            } else {
                $resultat = "PERDU 1";
            }

            $heure = date("i");
          //  $interval = $heure->diff($heureArrive);
          //  $interval->format('%I');
            /*
            $now = new DateTime('now');
            try {
                $dateArr = new DateTime($heureArrive);
            } catch (\Exception $e) {
            }

            $diff = $dateArr->diff($now);
            $nb_jours = $diff->d;
*/
            // RAJOUTER COTE Negatif et positif !!!!!!!!!!
            /*
            if((int)substr($heureArrive, -2)==0 || (int)substr($heureArrive, -2)==51 || (int)substr($heureArrive, -2)==43 || (int)substr($heureArrive, -2)==34){
                if(((int)substr($heureArrive, -2) + (int)substr($heureArrive, -1)) - $heure < 5){
                    $resultat = "Vous avez GAGNÉ un bon d'achat de 20€";

                    $gagnant = new Gagnant();
                    $gagnant->setCreneau($heureDepart);   // HEURE EN DUR
                    $gagnant->setDateCreation(new DateTime());

                    $em->persist($gagnant);
                    $em->flush();
                } else {
                    $resultat =((int)substr($heureArrive, -1) + (int)substr($heureArrive, -2)). "PERDU 3 " .$heure .$nb_jours;
                }

            } elseif ((int)substr($heureArrive, -2)==20){

                if($heure - ((int)substr($heureArrive, -1) + (int)substr($heureArrive, -2))< 5){
                    $resultat = "Vous avez GAGNÉ un bon d'achat de 20€";

                    $gagnant = new Gagnant();
                    $gagnant->setCreneau($heureDepart);   // HEURE EN DUR
                    $gagnant->setDateCreation(new DateTime());

                    $em->persist($gagnant);
                    $em->flush();
                } else {
                    $resultat =((int)substr($heureArrive, -1) + (int)substr($heureArrive, -2)). "PERDU 3 " .$heure .$nb_jours;
                }
            }
*/
        } else {

            $resultat = "PERDU 2".$nb_jours;
        }
        return $resultat;
    }
}


