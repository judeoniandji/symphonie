<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $module = null;

    #[ORM\ManyToOne(targetEntity: Professeur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professeur $professeur = null;

    #[ORM\ManyToMany(targetEntity: Classe::class)]
    private Collection $classes;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Session::class, cascade: ['persist', 'remove'])]
    private Collection $sessions;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;
        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;
        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classes->contains($classe)) {
            $this->classes[] = $classe;
        }
        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        $this->classes->removeElement($classe);
        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCours($this);
        }
        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            if ($session->getCours() === $this) {
                $session->setCours(null);
            }
        }
        return $this;
    }
}
