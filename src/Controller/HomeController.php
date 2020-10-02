<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('accueil.html.twig',
            []);
    }
    /**
     * @Route("/halloween", name="halloween")
     */
    public function halloween()
    {
        $date = date("D");
        return $this->render('halloween.html.twig',
            ["date"=>$date]);
    }

}
