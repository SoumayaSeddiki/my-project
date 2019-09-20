<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
/*------------------image upload-----------------------------*/
    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="filename")
     */
    private $imageFile;
    /*---------------------------------------------------*/
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Occasion", inversedBy="produits")
     */
    private $occasion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Couleur", inversedBy="produits")
     */
    private $couleur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Taille", mappedBy="produit")
     */
    private $taille;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", inversedBy="produits")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="produit")
     */
    private $categorie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updated_at;
    
    public function __construct()
    {
        $this->occasions = new ArrayCollection();
        $this->occasion = new ArrayCollection();
        $this->couleur = new ArrayCollection();
        $this->taille = new ArrayCollection();
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection|Occasion[]
     */
    public function getOccasion(): Collection
    {
        return $this->occasion;
    }

    public function addOccasion(Occasion $occasion): self
    {
        if (!$this->occasion->contains($occasion)) {
            $this->occasion[] = $occasion;
        }

        return $this;
    }

    public function removeOccasion(Occasion $occasion): self
    {
        if ($this->occasion->contains($occasion)) {
            $this->occasion->removeElement($occasion);
        }

        return $this;
    }

    /**
     * @return Collection|couleur[]
     */
    public function getCouleur(): Collection
    {
        return $this->couleur;
    }

    public function addCouleur(couleur $couleur): self
    {
        if (!$this->couleur->contains($couleur)) {
            $this->couleur[] = $couleur;
        }

        return $this;
    }

    public function removeCouleur(couleur $couleur): self
    {
        if ($this->couleur->contains($couleur)) {
            $this->couleur->removeElement($couleur);
        }

        return $this;
    }

    /**
     * @return Collection|taille[]
     */
    public function getTaille(): Collection
    {
        return $this->taille;
    }

    public function addTaille(taille $taille): self
    {
        if (!$this->taille->contains($taille)) {
            $this->taille[] = $taille;
            $taille->setProduit($this);
        }

        return $this;
    }

    public function removeTaille(taille $taille): self
    {
        if ($this->taille->contains($taille)) {
            $this->taille->removeElement($taille);
            // set the owning side to null (unless already changed)
            if ($taille->getProduit() === $this) {
                $taille->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|commande[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
        }

        return $this;
    }

    public function removeCommande(commande $commande): self
    {
        if ($this->commande->contains($commande)) {
            $this->commande->removeElement($commande);
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updated_at = new \DateTime('now');
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
