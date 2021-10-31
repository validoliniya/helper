<?php

namespace App\Controller\View\Work;

use App\Entity\Work\Timer;
use App\Form\Work\EditType;
use App\Repository\Work\TimerRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param Request                $request
     * @return Response
     */
    public function list(TimerRepository $timerRepository){
        return $this->render('Work/timer.html.twig',[
            'times' => $timerRepository->findAll()
        ]);
    }

    /**
     * @Route("/create", name="timer.task.create", methods={"GET","POST"})
     * @param Request                $request
     * @return Response
     */
    public function create(Request $request,EntityManagerInterface $entityManager,UrlGeneratorInterface $urlGenerator)
    {
        $form = $this->createForm(EditType::class, new Timer());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('timer.task.list'));
        }
        return $this->render('Work/edit.html.twig',[
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}/edit", name="timer.task.edit", methods={"GET","POST"})
     * @param Request                $request
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
        if(null === $timer)
        {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(EditType::class, new Timer());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return new RedirectResponse($urlGenerator->generate('timer.task.list'));
        }
        return $this->render('Work/edit.html.twig',[
            'form' => $form
        ]);
    }
}
