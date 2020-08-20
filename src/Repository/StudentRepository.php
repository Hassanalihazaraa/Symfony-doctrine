<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Student::class);
        $this->manager = $manager;
    }

    //create
    public function saveStudent($firstName, $lastName, $email, $address, $teacher): void
    {
        $student = new Student();
        $student->setFirstName($firstName);
        $student->setLastName($lastName);
        $student->setEmail($email);
        $student->setAddress($address);
        $student->setTeacher($teacher);

        $this->manager->persist($student);
        $this->manager->flush();
    }

    //update
    public function updateStudent(Student $student): Student
    {
        $this->manager->persist($student);
        $this->manager->flush();

        return $student;
    }

    //delete
    public function removeStudent(Student $student): Student
    {
        $this->manager->remove($student);
        $this->manager->flush();
    }
}
