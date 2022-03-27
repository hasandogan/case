<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\DeveloperTask;
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
        $em = $this->getDoctrine()->getManager();
        $developer = $em->getRepository(Developer::class)->findAll();
        if (count($developer) > 2){
            $calculatorService->calculator();

        }else{
            return $this->redirect("/developer");

        }

        $developerTask = $em->getRepository(DeveloperTask::class)->findAll();

        return $this->render('calculator.html.twig',[
            'data' => $developerTask
        ]);
    }


    /**
     * @Route("/developer-list", "developer")
     */
    public function showDeveloperListAction(){
        $em = $this->getDoctrine()->getManager();
        $developer = $em->getRepository(Developer::class)->findAll();

        return $this->render('developer-list.html.twig',[
            'data' => $developer
        ]);
    }


}
