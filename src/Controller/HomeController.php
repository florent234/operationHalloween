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
        $dateFin = date("2020-10-03 18:30");
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
        if (date("14:00")<$heure){
            if($heure<date("15:00")){
                $hotesse = true;
            }
        }


        return $this->render('accueil.html.twig',
            ["message"=>$message, "date"=>$today, "hotesse"=>$hotesse]);
    }
    /**
     * @Route("/halloween", name="halloween")
     */
    public function halloween()
    {

        return $this->render('halloween.html.twig',
            []);
    }
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscripton(EntityManagerInterface $em,
                               Request $request)
    {
        $client = new Clients();
        $client->setDateCreation(new \DateTime());
        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('halloween',[]);
        }

        return $this->render('User/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

}
