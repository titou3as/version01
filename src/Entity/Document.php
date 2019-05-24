<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Polyfill\Intl\MessageFormatter\MessageFormatter;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Decision", mappedBy="document")
     */
    private $decisions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contributor", mappedBy="documents")
     */
    private $contributors;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt;

    public function __construct()
    {
        $this->decisions = new ArrayCollection();
        $this->contributors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoi(): ?string
    {
        return $this->doi;
    }

    public function setDoi(string $doi): self
    {
        $this->doi = $doi;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre($genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return Collection|Decision[]
     */
    public function getDecisions(): Collection
    {
        return $this->decisions;
    }

    public function addDecision(Decision $decision): self
    {
        if (!$this->decisions->contains($decision)) {
            $this->decisions[] = $decision;
            $decision->setDocument($this);
        }

        return $this;
    }

    public function removeDecision(Decision $decision): self
    {
        if ($this->decisions->contains($decision)) {
            $this->decisions->removeElement($decision);
            // set the owning side to null (unless already changed)
            if ($decision->getDocument() === $this) {
                $decision->setDocument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contributor[]
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
            $contributor->addDocument($this);
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): self
    {
        if ($this->contributors->contains($contributor)) {
            $this->contributors->removeElement($contributor);
            $contributor->removeDocument($this);
        }

        return $this;
    }
    /**
     * @param string $format
     * @return string
     */
    public function citation($format= null)
    {
        /*
        $dd= new \DateTime();

        $dft = new IntlDateFormatter('en',
            IntlDateFormatter::FULL,
            0,
            null,
            null,
            'dd/MM/yyyy h:m:s');
        dump($dft->format($dd));
        */
        $contributor_citation = '';
        $contributors = new ArrayCollection();
        foreach ($this->contributors as $contributor) {
            $contributors->add($contributor['last_name'] . ' ' . $contributor['first_name']);
            $contributorFormatter = new MessageFormatter('fr_FR', "{0} {1} ");
            $contributor_citation .= $contributorFormatter
                ->format(["<a href='#'>".$contributor['last_name'],
                    $contributor['first_name']."</a>"
                ]);
        }
        $doi_title_language = new MessageFormatter("fr_FR","$contributor_citation.{0}.{1}.{2}.{3}");
        if($format=='html')
            return $doi_title_language->format(["<a href='#'>".$this->getDoi()."</a>",$this->getTitle(),$this->getLanguage(),$this->genre]);
        else
            return $doi_title_language->format([$this->getDoi(),$this->getTitle(),$this->getLanguage(),$this->genre]);

    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
