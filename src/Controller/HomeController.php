<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/memo', name: 'home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $deletedTime = $form->get('deletedTime')->getData() + 60;

            $time = new DateTime();
            $time->modify('+' . $deletedTime . 'minutes');

            $memo->setDeletedTime($time);

            $entityManager->persist($memo);
            $entityManager->flush();

            return $this->redirectToRoute('memo', ['id' => $memo->getId()]);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HomeController',
        ]);
    }
}
