<?php

namespace App\Controller\View\Links;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/links",name="links.")
 */
class LinkController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
    {
        return $this->render('Links/links.html.twig');
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {

    }
}
