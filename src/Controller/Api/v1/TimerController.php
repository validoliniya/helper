<?php

namespace App\Controller\Api\v1;
use App\Repository\Work\TimerRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/api/v1/timer", name="api.timer.")
 */
class TimerController
{
    /**
     * @Route ("/{id}/start", name="start", methods={"POST"})
     */
    public function start(TimerRepository $timerRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $timer = $timerRepository->findOneById($id);
        if (!$timer) {
            return new JsonResponse('Timer not found', 400);
        }

        $timer->setTempDate(new DateTime());
        $entityManager->flush();

        return new JsonResponse('Timer started!');
    }

    /**
     * @Route ("/{id}/stop", name="stop", methods={"POST"})
     */
    public function stop(TimerRepository $timerRepository,EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $timer = $timerRepository->findOneById($id);
        if (!$timer) {
            return new JsonResponse('Timer not found', 400);
        }
        $now  = (new DateTime());
        $diff = $now->diff($timer->getTempDate());
        $timer->setHours($diff->h);
        $timer->setMinutes($diff->i);
        $timer->setTempDate($now);
        $entityManager->flush();

        return new JsonResponse('Timer stopped!');

    }
}
