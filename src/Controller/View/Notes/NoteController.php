<?php

namespace App\Controller\View\Notes;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/notes")
 */
class NoteController
{
    /**
     * @Route("/grid", name="notes.grid", methods={"GET"})
     * @param Request                $request
     * @return Response
     */
    public function grid(){

    }


    /**
     * @Route("/create", name="database.create", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function create(EntityManagerInterface $entityManager,Request                $request){

    }
}
