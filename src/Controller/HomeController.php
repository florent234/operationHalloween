<?php

namespace App\Controller;


use App\Entity\BonAchats;
use App\Entity\Clients;
use App\Entity\Gagnant;
use App\Entity\Rand;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

        $dateDebut = date("2020-10-21 08:00");  ///////// DATE DEBUT CONCOURS
        $dateFin = date("2020-10-31 21:00");    /////// DATE DE FIN DU CONCOURS

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
     * @Route("/jeuxHalloween/{id}", name="jeuxHalloween")
     * @param $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function jeuxHalloween($id, EntityManagerInterface $em )
    {
        date_default_timezone_set('Europe/Paris');

        // récupérer le tableau des bons achats
        $userRepo = $this->getDoctrine()->getRepository(BonAchats::class);
        $bonachats = $userRepo->findByDate(date("d"));

        $today = date("Y-m-d H:i");

        $dateDebut1 = date("2020-10-24 14:00");
        $dateFin1 = date("2020-10-24 18:00");

        $dateDebut2 = date("2020-10-28 14:00");
        $dateFin2 = date("2020-10-28 18:00");

        $dateDebut3 = date("2020-10-30 14:00");
        $dateFin3 = date("2020-10-30 18:00");

        $dateDebut4 = date("2020-10-31 14:00");
        $dateFin4 = date("2020-10-31 18:00");

        /////////////////////////////////////////  V   TEST    V    ////////////////////////////////////////////////////

        /*        $dateDebut1 = date("2020-10-15 10:00");
                $dateFin1 = date("2020-10-15 18:00");

                $dateDebut2 = date("2020-10-16 14:00");
                $dateFin2 = date("2020-10-16 18:00");

                $dateDebut3 = date("2020-10-17 14:00");
                $dateFin3 = date("2020-10-17 18:00");

                $dateDebut4 = date("2020-10-17 00:10"); ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE
                $dateFin4 = date("2020-10-17 23:00");  ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE
        */
        ////////////////////////////////  ^   TEST    ^  /////////////////////////////////////////////////////////
        if($dateDebut1<$today & $today<$dateFin1){
            $resultat = $this->mecanique1($bonachats, $em, $id);
        }
        if($dateDebut2<$today & $today<$dateFin2){
            $resultat = $this->mecanique2($bonachats, $em, $id);
        }
        if($dateDebut3<$today & $today<$dateFin3){
            $resultat = $this->mecanique2($bonachats, $em, $id);
        }
        if($dateDebut4<$today & $today<$dateFin4){
            $resultat = $this->mecanique1($bonachats, $em, $id);
        }

        return $this->render('halloween2.html.twig',
            ["resultat"=>$resultat
            ]);
    }

    public function action($bonachat, $em, $x, $id){
        if ($bonachat[$x]->getGagnant()==0) {
            if($x > 0 && $bonachat[($x-1)]->getGagnant() ==0){
                $resultat = $this->body($bonachat, ($x-1), $em, $id);
            } else {
                $heure = date ("H");
                $min = date ("i");

                // Les 5 derniers minutes d'un creneau == Gagnant à tout les coups si non gagnant
                if(($bonachat[$x]->getHeure()==$heure && $bonachat[$x]->getMin()-$min)<5 || (17==$heure && $min>40)){
                    $resultat = $this->body($bonachat, $x, $em, $id);
                } else {
                    $userRepo = $this->getDoctrine()->getRepository(Rand::class);
                    $rands = $userRepo->find(1);

                    // utiliser rand pour récupérer un numéro
                    $rand = rand(0, $rands->getRand());

                    //calculer et afficher le resultat

                    if ($rand === 0) {
                        $resultat = $this->body($bonachat, $x, $em, $id);
                    } else {
                        $resultat = "photos/bon_achat/PERDU.png";
                    }
                }
            }
        } else {
            $resultat = "photos/bon_achat/PERDU.png";
        }
        return $resultat;
    }

    public function body($bonachat, $x, $em, $id){
        $resultat = $bonachat[$x]->getBonachat();

        // Afficher que le bon achat est gagné
        $bonAchatRepo = $this->getDoctrine()->getRepository(BonAchats::class);
        $ba =$bonAchatRepo->find($bonachat[$x]->getId());

        $ba->setGagnant(1);
        $em->persist($ba);
        $em->flush();

        // Déclarer un gagnant
        $gagnant = new Gagnant();
        $gagnant->setIdGagnant($id);
        $gagnant->setDateCreation(new DateTime());
        $em->persist($gagnant);
        $em->flush();

        return $resultat;
    }

    public function mecanique1($bonAchat, $em, $id){
        date_default_timezone_set('Europe/Paris');
        $date = date('H:i');
        if($date>=date('14:00') & $date<date('14:30')){
            $resultat = $this->action($bonAchat, $em, 0, $id);
        }
        if($date>=date('14:30') & $date<date('15:00')) {
            $resultat = $this->action($bonAchat, $em, 1, $id);
        }
        if($date>=date('15:00') & $date<date('15:30')) {
            $resultat = $this->action($bonAchat, $em, 2, $id);
        }
        if($date>=date('15:30') & $date<date('16:00')){
            $resultat = $this->action($bonAchat, $em, 3, $id);
        }
        if($date>=date('16:00') & $date<date('16:30')) {
            $resultat = $this->action($bonAchat, $em, 4, $id);
        }
        if($date>=date('16:30') & $date<date('17:00')) {
            $resultat = $this->action($bonAchat, $em, 5, $id);
        }
        if($date>=date('17:00') & $date<date('17:30')) {
            $resultat = $this->action($bonAchat,$em, 6, $id);
        }
        if($date>=date('17:30') & $date<date('18:00')) {
            $resultat = $this->action($bonAchat,$em, 7, $id);
        }
        return $resultat;
    }

    public function mecanique2($bonAchat, $em, $id){
        date_default_timezone_set('Europe/Paris');
        $date = date('H:i');
        if($date>=date('14:00') & $date<date('14:34')){
            $resultat = $this->action($bonAchat, $em, 0, $id);
        }
        if($date>=date('14:34') & $date<date('15:09')) {
            $resultat = $this->action($bonAchat, $em, 1, $id);
        }
        if($date>=date('15:09') & $date<date('15:43')) {
            $resultat = $this->action($bonAchat, $em, 2, $id);
        }
        if($date>=date('15:43') & $date<date('16:17')){
            $resultat = $this->action($bonAchat, $em, 3, $id);
        }
        if($date>=date('16:17') & $date<date('16:51')) {
            $resultat = $this->action($bonAchat, $em, 4, $id);
        }
        if($date>=date('16:51') & $date<date('17:26')) {
            $resultat = $this->action($bonAchat, $em, 5, $id);
        }
        if($date>=date('17:26') & $date<date('18:00')) {
            $resultat = $this->action($bonAchat,$em, 6, $id);
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

