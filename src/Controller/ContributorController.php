<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Entity\Decision;
use App\Form\ContributorType;
use App\Repository\ContributorRepository;
use App\Repository\DecisionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/contributor")
 */
class ContributorController extends AbstractController
{
    /**
     * @Route("/index", name="contributor_index")
     * @var Request $request
     */
    public function index(ContributorRepository $repository, ObjectManager $manager,DecisionRepository $decisionRepository, Request $request): Response
    {
        /**
         * @var Contributor $contributor
         */
        $contributor = $this->getUser();

                        // $id = $contributor->getId();
       //dump($contributor);die;
        //dump($contributor);die;
                       // $contributor = $repository->find(id);
        /**
         * @var Decision[] $decisions
         */
        $decisions = $contributor->getDecisions()->filter(function ($decision){
            /** @var Decision $decision */
            return $decision->getIsTaken() == false;
        });
        $contributor->setDecisionsNT($decisions);
        $form = $this->createForm(ContributorType::class,$contributor);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /**
             * Update each decision with new  Form data
             */

            foreach ($contributor->getDecisionsNT() as $decision) {
                /**
                 * Access Roles Validation : If $contributor is the owner of $decision , He is allow to update it
                 */
                $this->isGranted('update', $contributor);

                switch ($decision->getDeposit()) {
                    case 'oui' :
                        $decision->setIsTaken(true);
                        $decision->setContent('Dépôt');
                        break;
                    case 'non' :
                        $decision->setIsTaken(true);
                        $decision->setContent('Refus Dépôt');
                        break;
                    default    : //$decision->setIsTaken(null);
                        $decision->setContent('En attente');
                        break;
                }



            }
                /**
                 * Saving the contributor's new state decisions
                 */

                $manager->flush();
                $this->addFlash('success','Les nouvelles décisions sont prises en compte');
                return $this->redirectToRoute('contributor_index');
            }

      // dump($decisions);die;
        return $this->render('contributor/index.html.twig', [
            'contributor' => $contributor,
            'decisions' => $decisions,
            'form' => $form->createView(),
        ]);
    }
}
