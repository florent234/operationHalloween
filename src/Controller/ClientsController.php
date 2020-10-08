<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ClientsController extends AbstractController
{

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscripton(EntityManagerInterface $em,
                               Request $request)
    {
        $client = new Clients();
        $client->setDateCreation(new \DateTime());
        $client->setTypeJeux("sansHotesse");
        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('halloween',['id' => $client->getUserId()]);
          //  return $this->redirectToRoute('halloween');

        }

        return $this->render('inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }
    /**
     * @Route("/inscriptions", name="inscriptions")
     */
    public function inscriptons(EntityManagerInterface $em,
                               Request $request)
    {
        $client = new Clients();
        $client->setDateCreation(new \DateTime());
       // $client->setTypeJeux("avecHotesse");
        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $client->setTypeJeux("avecHotesse");
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('jeuxHalloween',[]);
            //  return $this->redirectToRoute('halloween');

        }

        return $this->render('inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/clients/profils", name="clients_profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();


        return $this->render('User/profils.html.twig', [
            "utilisateurs"=>$utilisateurs]);
    }


    /**
     * @Route("/clients/supprimer/{id}", name="clients_profil_supprimer", requirements={"id": "\d+" });
     */
    public function supprimer($id, EntityManagerInterface $em){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateur =$userRepo->find($id);

        if($utilisateur->getActif()==true){
            $this->addFlash('success', 'Attention vous souhaitez supprimer un utilisateur !! L\'utilisateur dois être désactivé avant !!');
        } else {
            $em->remove($utilisateur);
            $em->flush();
        }

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        return $this->redirectToRoute('profils',[
            "utilisateurs"=>$utilisateurs
        ]);
    }

    /**
     * @Route("/clients/profil_afficher/{id}", name="clients_profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){


        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new Clients();



        return $this->render('User/profil_afficher.html.twig', [ "utilisateur"=>$utilisateur]);
    }


}
