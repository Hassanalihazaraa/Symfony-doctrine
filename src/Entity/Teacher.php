<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository", repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /** @ORM\Embedded(class="Address") */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="teacher", orphanRemoval=true)
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function setStudents(Student $student): Teacher
    {
        if ($this->students->contains($student)) {
            $this->students[] = $student;
            $student->setTeacher($this);
        }
        return $this;
    }

    public function deleteStudents(Student $student): Teacher
    {
        if (!$this->students->isEmpty()){
            $this->students->removeElement($student);
            $student->setTeacher(null);
        }
        return $this;
    }

    public function toArray(): array
    {
        $students = [];
        foreach ($this->getStudents() as $student) {
            $students[] = [
                'id' => $student,
                'firstname' => $student->getFirstName(),
                'lastname' => $student->getLastName(),
                'email' => $student->getEmail()
            ];
        }
        return [
            'id' => $this->getId(),
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress()->toArray(),
            'student' => $students
        ];
    }
}
