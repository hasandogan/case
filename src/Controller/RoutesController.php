<?php

namespace App\Controller;

use App\Entity\DeveloperEntity;
use App\Service\CalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoutesController extends AbstractController
{
    /**
     * @Route("/", "index")
     */
    public function showIndexAction(){
        return $this->render('base.html.twig');
    }
    /**
     * @Route("/developer", "developer")
     */
    public function showAddDeveloperAction(){
        return $this->render('developer.html.twig');
    }

    /**
     * @Route("/calculator", "calculator")
     */
    public function showCalculator(CalculatorService $calculatorService){
        $calculatorService->calculator();
        return $this->render('developer.html.twig');
    }


    /**
     * @Route("/developer-list", "developer")
     */
    public function showDeveloperListAction(){
        $em = $this->getDoctrine()->getManager();
        $developer = $em->getRepository(DeveloperEntity::class)->findAll();

        return $this->render('developer-list.html.twig',[
            'data' => $developer
        ]);
    }


}
