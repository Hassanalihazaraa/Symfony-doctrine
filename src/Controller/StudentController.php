<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

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
        if ($student === null) {
            throw new HttpException(404, "Student not found");

        }
        return new JsonResponse([$student->toArray(), Response::HTTP_OK]);
    }

    /**
     * @Route("/students", name="getAll_students", methods={"GET"})
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $students = $this->studentRepository->findAll();
        $data = [];
        foreach ($students as $student) {
            $data[] = $student->toArray();
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
        $address = new Address($data['address_street'], $data['address_street_number'], $data['address_city'], $data['address_zipcode']);
        $teacher = $teacherRepository->findOneBy(['id' => $data['teacher_id']]);

        $this->studentRepository->add($firstName, $lastName, $email, $address, $teacher);
        if ($firstName === null || $lastName === null || $email === null || $address === null || $teacher === null) {
            throw new NotFoundHttpException('Expecting mandatory inputs!');
        }
        return new JsonResponse(['status' => 'Student has been created successfully!'], Response::HTTP_CREATED);
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
        if ($student === null) {
            throw new HttpException(404, 'Student not found');
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $address = new Address($data['address_street'], $data['address_street_number'], $data['address_city'], $data['address_zipcode']);

        empty($data['firstname']) ? true : $student->setFirstName($data['firstname']);
        empty($data['lastname']) ? true : $student->setLastName($data['lastname']);
        empty($data['email']) ? true : $student->setEmail($data['email']);
        empty($data['address_street'] && $data['address_street_number'] && $data['address_city'] && $data['address_zipcode']) ? true : $student->setAddress($address);

        $teacher = $teacherRepository->findOneBy(['id' => $data['teacher_id']]);
        if ($teacher === null) {
            throw new HttpException(404, 'Teacher not found');
        }
        empty($data['teacher_id']) ? true : $student->setTeacher($teacher);

        $this->studentRepository->update($student);

        return new JsonResponse(['status' => 'Your data has been updated successfully'], Response::HTTP_OK);
    }

    /**
     * @Route("/students/{id}", name="delete_student", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $student = $this->studentRepository->findOneBy(['id' => $id]);
        if ($student === null) {
            throw new HttpException(404, 'Student not found');
        }
        $this->studentRepository->delete($student);

        return new JsonResponse(['status' => 'Student has been deleted successfully'], Response::HTTP_OK);
    }
}
