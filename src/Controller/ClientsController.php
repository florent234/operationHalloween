<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ClientsController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscripton(EntityManagerInterface $em,
                               Request $request)
    {
        date_default_timezone_set('Europe/Paris');

        $client = new Clients();
        $client->setDateCreation(new DateTime());

        $today = date("Y-m-d H:i");

        /* $dateDebut1 = date("2020-10-24 14:00");
        $dateFin1 = date("2020-10-24 18:00");

        $dateDebut2 = date("2020-10-28 14:00");
        $dateFin2 = date("2020-10-28 18:00");

        $dateDebut3 = date("2020-10-30 14:00");
        $dateFin3 = date("2020-10-30 18:00");

        $dateDebut4 = date("2020-10-31 14:00");
        $dateFin4 = date("2020-10-31 18:30"); */

        $dateDebut1 = date("2020-10-15 11:00");
        $dateFin1 = date("2020-10-15 13:00");

        $dateDebut2 = date("2020-10-16 14:00");
        $dateFin2 = date("2020-10-16 20:00");

        $dateDebut3 = date("2020-10-17 00:00");
        $dateFin3 = date("2020-10-17 18:00");

        $dateDebut4 = date("2020-10-17 00:00"); ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE
        $dateFin4 = date("2020-10-17 23:00");  ////// A MODIFIER AVEC LA DATE DU 31 OCTOBRE

        if ($dateDebut1<$today & $today<$dateFin1 || $dateDebut2<$today & $today<$dateFin2 || $dateDebut3<$today &  $today<$dateFin3  || $dateDebut4<$today & $today<$dateFin4){
            $client->setTypeJeux('avecHotesse');
        } else {
            $client->setTypeJeux('sansHotesse');
        }

        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $em->persist($client);
            $em->flush();

            if ($dateDebut1<$today & $today<$dateFin1 || $dateDebut2<$today & $today<$dateFin2 || $dateDebut3<$today &  $today<$dateFin3  || $dateDebut4<$today & $today<$dateFin4){
                return $this->redirectToRoute('jeuxHalloween',['id' => $client->getUserId()]);
            } else {
                return $this->redirectToRoute('halloween',['id' => $client->getUserId()]);
            }
        }
        return $this->render('Client/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/admin/clients/profils", name="clients_profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findSansHotesse();


        return $this->render('Client/profils.html.twig', [
            "utilisateurs"=>$utilisateurs]);
    }
    /**
     * @Route("/admin/clients/profils_hotesse", name="clients_profils_hotesse")
     */
    public function listeUtilisateurHotesse(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findHotesse();


        return $this->render('Client/profils.html.twig', [
            "utilisateurs"=>$utilisateurs]);
    }


    /**
     * @Route("/admin/clients/supprimer/{id}", name="clients_profil_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateur =$userRepo->find($id);

        $direction = $utilisateur->getTypeJeux();

        $em->remove($utilisateur);
        $em->flush();

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        if($direction==="sansHotesse"){
            return $this->redirectToRoute('clients_profils',[
                "utilisateurs"=>$utilisateurs
            ]);
        } else {
            return $this->redirectToRoute('clients_profils_hotesse',[
                "utilisateurs"=>$utilisateurs
            ]);
        }

    }

    /**
     * @Route("/admin/profil_modifier/{id}", name="profil_modifier", requirements={"id": "\d+" })
     */
    public function modifier($id, EntityManagerInterface $em,
                             Request $request){


        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateur =$userRepo->find($id);

        $formInscription = $this->createForm(ClientsType::class, $utilisateur);
        $formInscription->handleRequest($request);

        if($formInscription->isSubmitted() && $formInscription->isValid()){

            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('admin',[]);
        }

        return $this->render('User/profil.html.twig', ["formInscription"=>$formInscription->createView()]);
    }
    /**
     * @Route("/admin/clients/profil_afficher/{id}", name="clients_profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){


        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new Clients();



        return $this->render('Client/profil_afficher.html.twig', [ "utilisateur"=>$utilisateur]);
    }


}
