<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\s;

class StudentController extends AbstractController
{

    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/students/{id}", name="get_student", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     */
    public function findOne(int $id): JsonResponse
    {
        $student = $this->studentRepository->findOneBy(['id' => $id]);
        if (!$student) {
            throw new HttpException(404, "Student not found");

        }
        return new JsonResponse([$student, Response::HTTP_OK]);
    }

    /**
     * @Route("/", name="getAll_students", methods={"GET"})
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $students = $this->studentRepository->findAll();
        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'id' => $student->getId(),
                'firstName' => $student->getFirstName(),
                'lastName' => $student->getLastName(),
                'email' => $student->getEmail(),
                'address' => $student->getAddress(),
                'teacher' => $student->getTeacher()
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/students", name="add_students", methods={"POST"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return JsonResponse
     * @throws \JsonException
     */
    public function add(Request $request, TeacherRepository $teacherRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $firstName = $data['firstname'];
        $lastName = $data['lastname'];
        $email = $data['email'];
        $address = new Address($data['address']['street'], $data['address']['streetnumber'], $data['address']['city'], $data['address']['zipcode']);
        $teacher = $teacherRepository->findOneBy(['id' => $data['teacher_id']]);

        if ($firstName === null || $lastName === null || $email === null || $address === null || $teacher === null) {
            throw new NotFoundHttpException('Expecting mandatory inputs!');
        }

        $this->studentRepository->saveStudent($firstName, $lastName, $email, $address, $teacher);
        return new JsonResponse(['status' => 'Student is created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/students/{id}", name="update_students", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return JsonResponse
     * @throws \JsonException
     */
    public function update(int $id, Request $request, TeacherRepository $teacherRepository): JsonResponse
    {
        $student = $this->studentRepository->findOneBy(['id' => $id]);
        if (!$student) {
            throw new HttpException(404, 'Not found');
        }
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        empty($data['firstName']) ? true : $student->setFirstName($data['firstName']);
        empty($data['lastName']) ? true : $student->setLastName($data['lastName']);
        empty($data['email']) ? true : $student->setEmail($data['email']);
        empty($data['address']) ? true : $student->setAddress(new Address($data['address']['street'], $data['address']['streetnumber'], $data['address']['city'], $data['address']['zipcode']));

        $teacher = $teacherRepository->findOneBy(['id' => $data['teacher_id']]);
        if (!$teacher) {
            throw new HttpException(404, 'Not found');
        }
        empty($data['teacher_id']) ? true : $student->setTeacher($teacher);

        $updatedStudent = $this->studentRepository->updateStudent($student);

        return new JsonResponse($updatedStudent->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/students/{id}", name="delete_student", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $student = $this->studentRepository->findOneBy(['id' => $id]);
        if (!$student) {
            throw new HttpException(404, 'Not found');
        }
        $this->studentRepository->removeStudent($student);

        return new JsonResponse(['status' => 'Student deleted'], Response::HTTP_NO_CONTENT);
    }
}
