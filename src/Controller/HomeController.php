<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(DecisionRepository $decisionRepository): Response
    {
       foreach ($decisionRepository->getAllNotTaken() as $decision)
           $documents[] = $decision->getDocument();
       dump($documents);
        return $this->render('home/index.html.twig',[
            'documents' => $documents
        ]);
    }
}
