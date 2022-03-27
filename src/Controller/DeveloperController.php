<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Service\DeveloperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{

    /**
     * @Route("/addDeveloper","addDeveloper")
     */
    public function addDeveloperAction(DeveloperService $developerService, Request $request)
    {
        $developerService->createDeveloper($request->request->all());
        return new Response($this->redirect("/developer-list"));
    }


}
