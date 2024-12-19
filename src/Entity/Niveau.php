<?php


namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Classe::class)]
    private Collection $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
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
            $classe->setNiveau($this);
        }
        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        if ($this->classes->removeElement($classe)) {
            if ($classe->getNiveau() === $this) {
                $classe->setNiveau(null);
            }
        }
        return $this;
    }
}
