<?php

namespace App\Command;

use App\Entity\Contributor;
use App\Entity\Decision;
use App\Entity\Document;
use App\Repository\ContributorRepository;
use App\Repository\DocumentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ContributorDecisionCommand extends Command
{
    protected static $defaultName = 'decision:contributor:create';
    private $documentRepository;
    private $contributorRepository;
    private $manager;

    public function __construct(ContributorRepository $contributorRepository, ObjectManager $manager,DocumentRepository $documentRepository)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->contributorRepository = $contributorRepository;
        $this->documentRepository = $documentRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a all decisions per each document related to a contributor not yet published into HAL')
         /*   ->addArgument('admin',
                InputArgument::OPTIONAL,
                'Administrator multiple decisions')
         */
            ->addOption('contributor',
                'c',
                InputOption::VALUE_REQUIRED,
                'The identifiant of the contributor concerned about new decisions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $conID = $input->getOption('contributor');
        /**
         * Search the Contributor's id = $conID
         * @var Contributor $contributor
         */
        $contributor = $this->contributorRepository->find($conID);
        /**
         * Extracting all document's contributor without decisions
         */
        $documents = $contributor->getDocuments();
        /**
         * Per each Document , creating a new decision
         * @var Document[] $documents
         * @var Document $document
         */
        foreach ($documents as $document) {
                 if($document->getDecisions()->count()==0) {
                        // $output->writeln($document->getTitle());
     /**
      * Adding the new Decision (isTaken = false)
      */
                     $decision = new Decision();
                     $decision->setContent('En cours de construction')
                                ->setDocument($document)
                                ->setContributor($contributor)
                                ->setCreatedAt(new \DateTime())
                                ->setIsTaken(false)
                                ->setDeposit('null');
     /**
      * Persist the Decision and Flush into the Database
      */
                    $this->manager->persist($decision);
 }
                }
        $this->manager->flush();
        //}
        $io->success('Félicitations : Les décisions relatives au contributeur '.$contributor->getUsername().' sont crées .');
    }
}
