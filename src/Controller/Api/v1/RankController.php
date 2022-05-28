<?php

namespace App\Controller\Api\v1;

use App\Repository\Command\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/rank", name="api.v1.rank.")
 */
class RankController extends AbstractController
{
    /**
     * @Route("/{id}/increase", name="increase", methods={"PUT"})
     */
    public function increment(int $id, CommandRepository $commandRepository,EntityManagerInterface $entityManager): Response
    {
        $command = $commandRepository->findOneById($id);
        if(empty($command)) {
            throw new BadRequestHttpException();
        }

        $command->incrementRank();
        $entityManager->flush($command);

        return new Response();
    }

}
