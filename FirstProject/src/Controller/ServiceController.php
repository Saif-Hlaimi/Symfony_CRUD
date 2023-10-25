<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    

    #[Route('/service', name: 'app_service')]

   
    public function index(): Response
    {
  

        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }


    #[Route('/service/{name}/{emplo}', name   : 'app_show')]
    public function ShowService($name , $emplo)
    {
     
      return $this->render('service/showService.html.twig', ['name' => $name,
      'emplo' => $emplo, ]);
    //   return $this->render('service/showService.html.twig', ['emplo' => $emplo]);

    }
  


 
}

