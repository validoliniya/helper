<?php

namespace App\Controller\View\Json;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/json", name="json")
 */
class JsonController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"GET", "POST"})
     */
    public function list(): Response
    {
        return $this->render('Json/list.html.twig');
    }

}
