<?php


namespace App\Controller;


use App\Entity\Document;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @Route("/document/{id}",name="document_index",methods={"GET"})
     * @param DocumentRepository $documentRepository
     * @return Response
     */
    public function index($id, DocumentRepository $documentRepository): Response{
        /**
         * @var  Document $document
         */
        $document = $documentRepository->find($id);
        $response = new Response();
        $response->headers->set('Content-Type','xml');
       return $this->render('document/index.xml.twig',
                            ['document' => $document ],
                            $response);
    }
}