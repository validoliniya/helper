<?php

namespace App\Controller\View\Links;

use App\Entity\Links\Link;
use App\Form\Links\LinkCreateForm;
use App\Repository\Links\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @param UrlGeneratorInterface  $urlGenerator
     * @return Response
     */
    public function create(EntityManagerInterface $entityManager, Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $link      = new  Link();
        $sectionId = $request->query->get('section');
        $form      = $this->createForm(LinkCreateForm::class, $link, ['section' => $sectionId]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $database = $form->getData();
            $entityManager->persist($database);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('links.list'));
        }

        return $this->render('Links/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @param int                    $id
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @param UrlGeneratorInterface  $urlGenerator
     * @param LinkRepository         $linkRepository
     * @return Response
     */
    public function edit(int $id, EntityManagerInterface $entityManager, Request $request, UrlGeneratorInterface $urlGenerator, LinkRepository $linkRepository): Response
    {
        $sectionId = $request->query->get('section');
        $link      = $linkRepository->findOneById($id);
        $form      = $this->createForm(LinkCreateForm::class, $link, ['section' => $sectionId]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $database = $form->getData();
            $entityManager->persist($database);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('links.list'));
        }

        return $this->render('Links/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
