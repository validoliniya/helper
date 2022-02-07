<?php

namespace App\Controller\Api\v1;

use App\Repository\Links\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/link", name="api.v1.link.")
 */
class LinkController extends AbstractController
{
    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(int $id, LinkRepository $linkRepository, EntityManagerInterface $entityManager): Response
    {
        $link = $linkRepository->findOneById($id);
        if ($link === null) {

        }

        $entityManager->remove($link);
        $entityManager->flush();

        return new Response();
    }

}
