<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Teacher::class);
        $this->manager = $manager;
    }

    //create
    public function add($firstName, $lastName, $email, $address)
    {
        $teacher = new Teacher();
        $teacher->setFirstName($firstName);
        $teacher->setLastName($lastName);
        $teacher->setEmail($email);
        $teacher->setAddress($address);

        $this->manager->persist($teacher);
        $this->manager->flush();
    }

    //update
    public function update(Teacher $teacher)
    {
        $this->manager->persist($teacher);
        $this->manager->flush();

        return $teacher;
    }

    //delete
    public function delete(Teacher $teacher)
    {
        $this->manager->remove($teacher);
        $this->manager->flush();
    }
}
