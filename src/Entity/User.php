<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("eid")
 * @UniqueEntity(fields={"lastname", "firstname"})
 * @ORM\HasLifecycleCallbacks()
 */
class User
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
     *     pattern="/^[A-Za-z ]+$/i",
     *     message="Characters not allowed"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=60)
     * @Assert\Regex(
     *     pattern="/^[A-Za-z ]+$/i",
     *     message="Characters not allowed"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Length(min=15, max=15)
     * @Assert\Regex(
     *     pattern="/^[0-9\.\-]+$/i",
     *     message="Characters not allowed"
     * )
     */
    private $eid;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\ManyToMany(targetEntity=Lecture::class, inversedBy="users")
     */
    private $lecture;

    public function __construct()
    {
        $this->lecture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = strtoupper($lastname);

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = ucfirst($firstname);

        return $this;
    }

    public function getEid(): ?string
    {
        return $this->eid;
    }

    public function setEid(?string $eid): self
    {
        $this->eid = $eid;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection|Lecture[]
     */
    public function getLecture(): Collection
    {
        return $this->lecture;
    }

    public function addLecture(Lecture $lecture): self
    {
        if (!$this->lecture->contains($lecture)) {
            $this->lecture[] = $lecture;
        }

        return $this;
    }

    public function removeLecture(Lecture $lecture): self
    {
        $this->lecture->removeElement($lecture);

        return $this;
    }
}
