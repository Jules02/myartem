<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $school = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'associations')]
    private Collection $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(?string $school): static
    {
        $this->school = $school;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Student $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addAssociation($this);
        }

        return $this;
    }

    public function removeMember(Student $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeAssociation($this);
        }

        return $this;
    }
}
