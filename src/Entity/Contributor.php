<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributorRepository")
 */
class Contributor
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Decision", mappedBy="contributor")
     */
    private $decisions;

    private $decisionsNT;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Document", inversedBy="contributors")
     */
    private $documents;

    public function __construct()
    {
        $this->decisions = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
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
            $decision->setContributor($this);
        }

        return $this;
    }

    public function removeDecision(Decision $decision): self
    {
        if ($this->decisions->contains($decision)) {
            $this->decisions->removeElement($decision);
            // set the owning side to null (unless already changed)
            if ($decision->getContributor() === $this) {
                $decision->setContributor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
        }

        return $this;
    }


    /**
     * @return Collection|Decision[]
     */
    public function getDecisionsNT(): Collection
    {
        return $this->decisionsNT;
    }

    public function addDecisionNT(Decision $decision): self
    {
        if (!$this->decisionsNT->contains($decision)) {
            $this->decisionsNT[] = $decision;
            $decision->setContributor($this);
        }

        return $this;
    }

    public function removeDecisionNT(Decision $decision): self
    {
        if ($this->decisionsNT->contains($decision)) {
            $this->decisionsNT->removeElement($decision);
            // set the owning side to null (unless already changed)
            if ($decision->getContributor() === $this) {
                $decision->setContributor(null);
            }
        }

        return $this;
    }

    /**
     * @param Decision[] $decisionsNT
     */
    public function setDecisionsNT($decisionsNT){
        $this->decisionsNT = $decisionsNT;
    }
}
