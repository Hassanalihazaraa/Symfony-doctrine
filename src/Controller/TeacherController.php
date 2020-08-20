<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TeacherController extends AbstractController
{
    /**
     * @Route("/teachers/{id}", name="get_teacher", methods={"GET"})
     */
    public function findOne()
    {

    }

    /**
     * @Route("/teachers", name="getAll_teacher", methods={"GET"})
     */
    public function findAll()
    {

    }

    /**
     * @Route("/teachers", name="add_teacher", methods={"POST"})
     */
    public function add()
    {

    }

    /**
     * @Route("/teachers/{id}", name="update_teacher", methods={"PUT"})
     */
    public function update()
    {

    }

    /**
     * @Route("/teachers/{id}", name="delete_teacher", methods={"DELETE"})
     */
    public function delete()
    {


    }
}
