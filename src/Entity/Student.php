<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    private int $id;

    /** @ORM\Column(type="string") * */
    private string $firstName;

    /** @ORM\Column(type="string") * */
    private string $lastName;

    /** @ORM\Column(type="string") * */
    private string $email;

    /** @ORM\Embedded(class="Address") */
    private Address $address;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private Teacher $teacher;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): string
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): string
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): string
    {
        $this->email = $email;
    }

    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): string
    {
        $this->teacher = $teacher;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): Address
    {
        $this->address = $address;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastName(),
            'email' => $this->getEmail(),
            'address' => $this->getAddress()->toArray(),
            'teacher_id' => $this->getTeacher()->getId()
        ];
    }
}
