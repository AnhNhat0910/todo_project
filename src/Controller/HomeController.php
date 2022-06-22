<?php

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController {
    /**
     * @Route("/home", name="home", methods={"GET"})
     */
    public function home(ManagerRegistry $doctrine) : Response {

        $repository = $doctrine->getRepository(Todo::class);
        $list = $repository->findBy([
                'isActive' => true
        ]);

        return $this->render('todo/index.html.twig', ['list' => $list]);
    }
    /**
     * @Route("/login", name="login_app", methods={"GET"})
     */
    public function index() : Response {

        return $this->render('login/loginForm.html.twig');
    }

}