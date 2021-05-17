<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     * @Assert\Regex(
     *     pattern="/^[0-9A-Za-z-_\-]+$/i",
     *     message="Characters not allowed"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Lecture::class, mappedBy="category")
     */
    private $lectures;

    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return strtoupper($this->name);
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Lecture[]
     */
    public function getLectures(): Collection
    {
        return $this->lectures;
    }

    public function addLecture(Lecture $lecture): self
    {
        if (!$this->lectures->contains($lecture)) {
            $this->lectures[] = $lecture;
            $lecture->setCategory($this);
        }

        return $this;
    }

    public function removeLecture(Lecture $lecture): self
    {
        if ($this->lectures->removeElement($lecture)) {
            // set the owning side to null (unless already changed)
            if ($lecture->getCategory() === $this) {
                $lecture->setCategory(null);
            }
        }

        return $this;
    }
}
