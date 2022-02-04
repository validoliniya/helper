<?php

namespace App\Controller\View\Links;

use App\Repository\Links\LinkRepository;
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
     * @param LinkRepository $linkRepository
     * @return Response
     */
    public function list(LinkRepository $linkRepository): Response
    {
        $links = $linkRepository->findAllBySections();

        return $this->render('Links/links.html.twig', [
            'links'    => $links,
            'sections' => array_keys($links)
        ]);
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
