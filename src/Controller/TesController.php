<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesController extends AbstractController
{
    #[Route('/tes', name: 'app_tes')]
    public function index(): Response
    {
        return $this->render('tes/index.html.twig', [
            'controller_name' => 'TesController',
        ]);
    }
}
