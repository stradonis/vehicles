<?php

namespace App\UI\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VueController extends AbstractController
{
    #[Route('/app/{route}', name: 'vue', requirements: ['route' => '.*'])]
    public function index(): Response
    {
        return $this->render('vue/index.html.twig', [
            'controller_name' => 'VueController',
        ]);
    }
}
