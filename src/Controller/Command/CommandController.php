<?php

namespace App\Controller\Command;

use App\Entity\Command\Command;
use App\Form\Command\EditType;
use App\Repository\Command\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/command")
 */
class CommandController extends AbstractController
{
    /**
     * @Route("/list", name="command.list", methods={"GET"})
     * @param CommandRepository $commandRepository
     * @return Response
     */
    public function list(CommandRepository $commandRepository): Response
    {
        return $this->render('Command/list.html.twig',[
           'commands' => $commandRepository->getLastByNumber(15)
        ]);
    }

    /**
     * @Route("/create", name="command.create", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(EditType::class, new Command());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $entityManager->persist($command);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('command.list'));
        }

        return $this->render('Command/create.html.twig', [
            'form'         => $form->createView(),
            'is_immutable' => false
        ]);
    }

    /**
     * @Route("/{id}/update", name="command.update", methods={"GET", "POST"})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function update(EntityManagerInterface $entityManager, Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(EditType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $database = $form->getData();
            $entityManager->persist($database);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('command.list'));
        }

        return $this->render('Command/create.html.twig', [
            'form' => $form
        ]);
    }

}