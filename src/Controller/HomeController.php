<?php

namespace App\Controller;

use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(DocumentRepository $repository) :Response
    {
        $documents  = $repository->findAll();
        return $this->render('home/index.html.twig', [
            'documents' => $documents,
        ]);
    }
}
