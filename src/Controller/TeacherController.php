<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class TeacherController extends AbstractController
{
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @Route("/teachers/{id}", name="get_teacher", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     */
    public function findOne(int $id): JsonResponse
    {
        $teacher = $this->teacherRepository->findOneBy(['id' => $id]);
        if ($teacher === null) {
            throw new HttpException(404, "Teacher not found");

        }
        return new JsonResponse([$teacher->toArray(), Response::HTTP_OK]);
    }

    /**
     * @Route("/teachers", name="getAll_teacher", methods={"GET"})
     * * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        $teachers = $this->teacherRepository->findAll();
        $data = [];
        foreach ($teachers as $teacher) {
            $data[] = $teacher->toArray();
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/teachers", name="add_teacher", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \JsonException
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $firstName = $data['firstname'];
        $lastName = $data['lastname'];
        $email = $data['email'];
        $address = new Address($data['address_street'], $data['address_street_number'], $data['address_city'], $data['address_zipcode']);

        $this->teacherRepository->add($firstName, $lastName, $email, $address);
        if ($firstName === null || $lastName === null || $email === null || $address === null) {
            throw new NotFoundHttpException('Expecting mandatory inputs!');
        }
        return new JsonResponse(['status' => 'Teacher has been created successfully!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/teachers/{id}", name="update_teacher", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws \JsonException
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $teacher = $this->teacherRepository->findOneBy(['id' => $id]);
        if ($teacher === null) {
            throw new HttpException(404, 'Teacher not found');
        }

        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $address = new Address($data['address_street'], $data['address_street_number'], $data['address_city'], $data['address_zipcode']);

        empty($data['firstname']) ? true : $teacher->setFirstName($data['firstname']);
        empty($data['lastname']) ? true : $teacher->setLastName($data['lastname']);
        empty($data['email']) ? true : $teacher->setEmail($data['email']);
        empty($data['address_street'] && $data['address_street_number'] && $data['address_city'] && $data['address_zipcode']) ? true : $teacher->setAddress($address);

        $this->teacherRepository->update($teacher);

        return new JsonResponse(['status' => 'Your data has been updated successfully'], Response::HTTP_OK);
    }

    /**
     * @Route("/teachers/{id}", name="delete_teacher", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $teacher = $this->teacherRepository->findOneBy(['id' => $id]);
        if ($teacher === null) {
            throw new HttpException(404, 'Teacher not found');
        }
        $this->teacherRepository->delete($teacher);

        return new JsonResponse(['status' => 'Teacher has been deleted successfully'], Response::HTTP_OK);
    }
}
