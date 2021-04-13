<?php

namespace App\Controller\Database;

use App\Entity\Database\Database;
use App\Form\Database\DatabaseCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/database")
 */
class DatabaseController extends AbstractController
{
    /**
     * @Route("/create", name="database.create", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function create(EntityManagerInterface $entityManager,Request $request): Response
    {
        $database = new Database();
        $form = $this->createForm(DatabaseCreateForm::class,$database);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $database = $form->getData();
            $entityManager->persist($database);
            $entityManager->flush();
        }
        return $this->render('Database/create.html.twig', [
            'form'          => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit", name="database.edit", methods={"GET", "POST"})
     *
     */
    public function update(){

    }

}