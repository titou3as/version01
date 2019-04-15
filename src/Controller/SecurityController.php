<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Form\ContributorInscriptionType;
use App\Form\ContributorType;
use App\Form\ContributorConnexionType;
use App\Repository\DocumentRepository;
use App\Repository\ContributorRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(DocumentRepository $repository) :Response
    {
        $documents  = $repository->findAll();
        return $this->render('security/index.html.twig', [
            'documents' => $documents,
        ]);
    }
    /**
     * @Route("/inscription", name = "home_inscription")
     */
    public function inscription(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder):Response
    {

        $contributor = new Contributor();
        $form= $this->createForm(ContributorInscriptionType::class,$contributor);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $hash = $encoder->encodePassword($contributor,$contributor->getPassword());
            $contributor->setPassword($hash);
            $manager->persist($contributor);
            $manager->flush();
        }
        return $this->render('security/inscription.html.twig',[
                    'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/connexion", name="home_connexion")
     */
    public function login(Request $request, ContributorRepository $repository): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logout", name="home_logout" )
     */
    public function logout(){

    }
}