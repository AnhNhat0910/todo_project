<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Datetime;
use Doctrine\Common\Collections\Expr\Value;

class TodoController extends AbstractController 
{


    /**
     * @Route("/todo", name= "create_todo")
     */
    public function createTodo(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $list_todo = new Todo();
        $list_todo->setName($_POST['name']);
        $list_todo->setDescription($_POST['des']);
        if(isset($_POST['status'])) {
            $list_todo->setStatus($_POST['status']);
          } else {
             $list_todo->setStatus(false);
          }

        $date = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
         $list_todo->setCreateDate($date);
        // tell Doctrine you want to (eventually) save the Todo (no queries yet)
        $entityManager->persist($list_todo);

        // the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

      /**
     * @Route("/list/update/{id}")
     */
    public function viewUpdate(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Todo::class);
        // look for *all* Product objects
        $list_todo = $repository->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // $list_todo->setName('New product name!');

        //$entityManager->flush();

        return $this->render('update.html.twig', ['item' => $list_todo]);
    }

       /**
     * @Route("/list/submit/{id}")
     */
    public function submitUpdate(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

         $list_todo->setName($_POST['name_update']);
         $list_todo->setDescription($_POST['des_update']);
         if(isset($_POST['status_update'])) {
            $list_todo->setStatus($_POST['status_update']);
        } else {
            $list_todo->setStatus(false);
        }

        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
     /**
     * @Route("/list/{id}", name="product_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $list_todo = $doctrine->getRepository(Todo::class)->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$list_todo->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

     /**
     * @Route("/list/do/{id}")
     */
    public function do(ManagerRegistry $doctrine, int $id): Response
    {

        $entityManager = $doctrine->getManager();
        $list_todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $list_todo->setStatus(true);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

     /**
     * @Route("/list/undo/{id}")
     */
    public function undo(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        
        $list_todo->setStatus(false);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

      /**
     * @Route("/list/delete/{id}")
     */
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $entityManager->getRepository(Todo::class)->find($id);

        if (!$list_todo) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
        
        $entityManager->remove($list_todo);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

   
}
