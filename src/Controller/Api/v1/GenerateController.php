<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV4;

class GenerateController extends AbstractController
{
    /**
     * @Route ("/generate_uuid_v4/token", name="generate_uuid_v4.token", methods={"GET"})
     */
    public function generateToken(): Response
    {
        return new Response(UuidV4::v4()->toRfc4122());
    }
}
