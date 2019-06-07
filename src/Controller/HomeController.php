<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(EventRepository $eventRepository): Response
    {
        $first = $eventRepository->findBy([], ['date'=>'DESC'], 1);
        dd($first);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'first' => $first,
        ]);
    }
}
