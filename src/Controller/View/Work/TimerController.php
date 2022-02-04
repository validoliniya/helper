<?php

namespace App\Controller\View\Work;

use App\Entity\Work\Timer;
use App\Form\Work\EditType;
use App\Repository\Work\TimerRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/timer")
 */
class TimerController extends AbstractController
{

    /**
     * @Route("/list", name="timer.list", methods={"GET"})
     * @param Request            $request
     * @param TimerRepository    $timerRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function list(Request $request, TimerRepository $timerRepository, PaginatorInterface $paginator)
    {
        $queryBuilder = $timerRepository->createQueryBuilder('t');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('Work/timer.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/create", name="timer.task.create", methods={"GET","POST"})
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface  $urlGenerator
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $form = $this->createForm(EditType::class, new Timer());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timer = $form->getData();
            $timer->setTempDate(new DateTime());
            $entityManager->persist($timer);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('timer.list'));
        }

        return $this->render('Work/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="timer.task.edit", methods={"GET","POST"})
     * @param int                    $id
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface  $urlGenerator
     * @param TimerRepository        $timerRepository
     * @return Response
     */
    public function edit(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        TimerRepository $timerRepository
    )
    {
        $timer = $timerRepository->findOneById($id);
        if (null === $timer) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(EditType::class, $timer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timer = $form->getData();
            $timer->setTempDate(new DateTime());
            $entityManager->persist($timer);
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('timer.list'));
        }

        return $this->render('Work/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
