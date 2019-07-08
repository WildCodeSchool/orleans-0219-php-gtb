<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Event;
use App\Form\MemberCommentType;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use App\Repository\GaleryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MemberController
 * @package App\Controller
 * @Route("/member")
 */
class MemberController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @param EventRepository $eventRepository
     * @Route("/event_to_come", name="member_event_to_come")
     * @return Response
     */
    public function showEventsToCome(EventRepository $eventRepository, UserRepository $userRepository): Response
    {
        return $this->render('member/event_to_come.html.twig', [
            'events' => $eventRepository->findBy(['isPrivate' => true], ['date' => 'DESC'], 6),
            'user' => $userRepository->findOneBy([])
        ]);
    }

    /**
     * @param UserRepository $userRepository
     * @param Request $request
     * @param Event $event
     * @Route("/event_to_come/{id}", name="show_event_to_come", methods={"GET","POST"})
     * @return Response
     */
    public function newMemberComment(
        Request $request,
        Event $event,
        UserRepository $userRepository
    ): Response {
        $commentMember = new Comment();
        $form = $this->createForm(MemberCommentType::class, $commentMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $commentMember->setEvent($event);
            $commentMember->setUser($this->getUser());
            $commentMember->setDate(new \DateTime());

            $entityManager->persist($commentMember);
            $entityManager->flush();

            return $this->redirectToRoute('show_event_to_come', ['id' => $event->getId()]);
        }

        return $this->render('member/show_event_to_come.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
            'user' => $userRepository->findOneBy([])
        ]);
    }

    /**
     * @Route("/profil", name="member_page")
     * @return Response
     */
    public function index(): Response
    {
        $user=$this->getUser();
        return $this->render('member_page/index.html.twig', [

            'user' => $user,
        ]);
    }


    /**
     * @param UserRepository $userRepository
     * @Route("/galery", name="member_galery")
     * @param GaleryRepository $galeryRepository
     * @return Response
     */
    public function galery(GaleryRepository $galeryRepository, UserRepository $userRepository): Response
    {
        return $this->render('private_galery/index.html.twig', [
            'galery' => $galeryRepository->findAll(),
            'user' => $userRepository->findOneBy([])
        ]);
    }
}
