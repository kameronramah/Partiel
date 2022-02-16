<?php

namespace App\Controller;

use App\Repository\MemoRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoController extends AbstractController
{   

    #[Route('/memo/{id}', name: 'memo')]
    public function index(MemoRepository $memoRepository, int $id): Response
    {
        $memo = $memoRepository->findById($id);

        if(count($memo) !== 0) {
            $memo = $memo[0];
            $moment = new DateTime();
            $moment->modify('+60 minutes');
            if($memo->getDeletedTime() < $moment) {
                $response = new Response();
                $response->headers->set('Content-Type', 'text/html');
                $response->setStatusCode(410);
                return $response;
            }
        }
        else{
            $response = new Response();
            $response->headers->set('Content-Type', 'text/html');
            $response->setStatusCode(410);
            return $response;
        }

        return $this->render('memo/index.html.twig', [
            'memo' => $memo,
            'controller_name' => 'MemoController'
        ]);
    }

    #[Route('/memo/allMemos', name: 'allMemos')]
    public function allMemos(MemoRepository $memoRepository): Response
    {
        $memos = $memoRepository->findAll();

        return $this->render('memo/allMemos.html.twig', [
            'memos' => $memos,
            'controller_name' => 'MemoController'
        ]);
    }
}
