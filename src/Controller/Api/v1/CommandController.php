<?php

namespace App\Controller\Api\v1;

use App\Repository\Command\CommandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/command", name="api.v1.command.")
 */
class CommandController extends AbstractController
{
    /**
     * @Route ("/{id}/delete", name="delete", methods={"DELETE"})
     */
    public function delete(CommandRepository $commandRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {

        $command = $commandRepository->findOneById($id);
        if ($command) {
            $entityManager->remove($command);
            $entityManager->flush();

            return new JsonResponse('Command deleted!');
        } else {
            return new JsonResponse('Command not found', 400);
        }
    }
}
