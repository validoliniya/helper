<?php

namespace App\Controller\Database;

use App\Entity\Database\Database\Database\Database\Database\Database;
use App\Form\Database\DatabaseCreateForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/database")
 */
class DatabaseController extends AbstractController
{
    //     * @Security("is_granted('ROLE_ADMIN') or (is_granted('ROLE_USER'))
    /**
     * @Route("/create", name="database.create", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     */
    public function create(EntityManagerInterface $entityManager,Request $request){
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