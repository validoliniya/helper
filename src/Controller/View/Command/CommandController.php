<?php

namespace App\Controller\View\Command;

use App\Entity\Command\Command;
use App\Form\Command\EditType;
use App\Repository\Command\CommandRepository;
use App\Repository\Command\CommandSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
    public function list(CommandRepository $commandRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $commandRepository->createQueryBuilder('c'),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('Command/list.html.twig',[
           'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/{section_id}/list", name="command.section.list", methods={"GET"})
     * @param CommandRepository $commandRepository
     * @return Response
     */
    public function showSection(CommandRepository $commandRepository,Request $request,CommandSectionRepository $commandSectionRepository,PaginatorInterface $paginator,int $section_id): Response
    {
        $queryBuilder = $commandRepository->getWithSearchBySectionIdQueryBuilder($section_id);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('Command/section_list.html.twig',[
            'pagination' => $pagination,
            'section' => $commandSectionRepository->findOneById($section_id)
        ]);
    }


    /**
     * @Route("/nav-menu", name="command.nav.menu", methods={"GET"})
     * @param CommandSectionRepository $commandSectionRepository
     * @return Response
     */
    public function navMenu(CommandSectionRepository $commandSectionRepository): Response
    {
        return $this->render('Layout/command-nav-menu.html.twig',[
            'sections' => $commandSectionRepository->findAll()
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
            'is_immutable' => true
        ]);
    }

    /**
     * @Route("/{id}/update", name="command.update", methods={"GET", "POST"})
     * @Entity("command", options={"mapping": {"id": "id"}})
     * @param EntityManagerInterface $entityManager
     * @param Request                $request
     * @return Response
     */
    public function update(EntityManagerInterface $entityManager, Request $request, UrlGeneratorInterface $urlGenerator,Command $command): Response
    {
        $form = $this->createForm(EditType::class,$command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $database = $form->getData();
            $entityManager->persist($database);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('command.list'));
        }

        return $this->render('Command/create.html.twig', [
            'form' => $form->createView(),
            'is_immutable' => $command->isImmutable()
        ]);
    }

}
