<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/teachers/{id}", name="get_teacher", methods={"GET"})
     * @param Teacher $teacher
     * @return Response
     */
    public function findOne(Teacher $teacher): Response
    {

    }

    /**
     * @Route("/teachers", name="getAll_teacher", methods={"GET"})
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function findAll(TeacherRepository $teacherRepository): Response
    {

    }

    /**
     * @Route("/teachers", name="add_teacher, methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $teacher = new Teacher();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($teacher);
        $entityManager->flush();
    }

    /**
     * @Route("/teachers/{id}", name="update_teacher", methods={"POST"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function update(Request $request, Teacher $teacher): Response
    {

    }

    /**
     * @Route("/teachers/{id}", name="delete_teacher", methods={"DELETE"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function delete(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('delete' . $teacher->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($teacher);
            $entityManager->flush();
        }
    }
}
