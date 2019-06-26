<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'eventsMostCommented' => $eventRepository->getEventCommentNumber('DESC'),
            'eventsLessCommented' => $eventRepository->getEventCommentNumber('ASC'),
        ]);
    }
}