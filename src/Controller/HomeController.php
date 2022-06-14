<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;

class HomeController extends AbstractController {

    /**
     * @Route("/home", name="home")
     */
    public function home(ManagerRegistry $doctrine) : Response {

        $repository = $doctrine->getRepository(Todo::class);
        // look for *all* Product objects
        $list = $repository->findAll();

    //     $datetime = DateTime::createFromFormat('j-M-Y', '30-September-2019');
  
    // // Getting the new formatted datetime 
    //     echo $datetime->format('Y-m-d');

        return $this->render('base.html.twig', ['list' => $list]);
    }

}