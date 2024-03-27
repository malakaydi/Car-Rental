<?php

namespace App\Controller;

use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'welcome')]
    public function welcome(): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('welcome/welcome.html.twig', [
            'controller_name' => 'WelcomeController','voitures' => $voitures,
        ]);}
}
