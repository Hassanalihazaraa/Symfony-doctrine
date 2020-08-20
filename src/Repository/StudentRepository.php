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
    public function add($firstName, $lastName, $email, $address, $teacher)
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
    public function update(Student $student)
    {
        $this->manager->persist($student);
        $this->manager->flush();

        return $student;
    }

    //delete
    public function delete(Student $student)
    {
        $this->manager->remove($student);
        $this->manager->flush();
    }
}
