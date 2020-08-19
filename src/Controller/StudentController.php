<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/students/{id}", name="get_student", methods={"GET"})
     * @param Student $student
     * @return Response
     */
    public function findOne(Student $student): Response
    {

    }

    /**
     * @Route("/students", name="getAll_students", methods={"GET"})
     * @param StudentRepository $studentRepository
     * @return Response
     */
    public function findAll(StudentRepository $studentRepository): Response
    {

    }

    /**
     * @Route("/students", name="add_students", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {

    }

    /**
     * @Route("/students/{id}", name="update_students", methods={"PUT"})
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function update(Request $request, Student $student): Response
    {

    }

    /**
     * @Route("/students/{id}", name="delete_student", methods={"DELETE"})
     * @param Request $request
     * @param Student $student
     * @return Response
     */
    public function delete(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_index');
    }
}
