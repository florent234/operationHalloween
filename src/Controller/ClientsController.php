<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
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
        $client = new Clients();
        $client->setDateCreation(new \DateTime());
        $client->setTypeJeux('sansHotesse');
        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('halloween',['id' => $client->getUserId()]);
          //  return $this->redirectToRoute('halloween');

        }

        return $this->render('Client/inscription.html.twig',
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
        $client->setTypeJeux('avecHotesse');
        $formInscription = $this->createForm(ClientsType::class, $client);
        $formInscription->handleRequest($request);

        if( $formInscription->isSubmitted() && $formInscription->isValid()){
            $client->setTypeJeux('avecHotesse');
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('jeuxHalloween',[]);
            //  return $this->redirectToRoute('halloween');

        }

        return $this->render('Client/inscription.html.twig',
            ["formInscription"=>$formInscription->createView()]);
    }

    /**
     * @Route("/clients/profils", name="clients_profils")
     */
    public function listeUtilisateur(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findSansHotesse();


        return $this->render('Client/profils.html.twig', [
            "utilisateurs"=>$utilisateurs]);
    }
    /**
     * @Route("/clients/profils_hotesse", name="clients_profils_hotesse")
     */
    public function listeUtilisateurHotesse(){

        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findHotesse();


        return $this->render('Client/profils.html.twig', [
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

        return $this->redirectToRoute('clients_profils',[
            "utilisateurs"=>$utilisateurs
        ]);
    }

    /**
     * @Route("/profil_modifier/{id}", name="profil_modifier", requirements={"id": "\d+" })
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
     * @Route("/clients/profil_afficher/{id}", name="clients_profil_afficher", requirements={"id": "\d+" })
     */
    public function afficher($id){


        $userRepo = $this->getDoctrine()->getRepository(Clients::class);
        $utilisateurs =$userRepo->findAll();

        $utilisateur = new Clients();



        return $this->render('Client/profil_afficher.html.twig', [ "utilisateur"=>$utilisateur]);
    }


}
