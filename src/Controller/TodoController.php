<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Datetime;

class TodoController extends AbstractController 
{
     /**
     * @var TodoRepository
     */
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository){
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/todo", name= "createTodo", methods={"POST"})
     */
    public function createTodo(ManagerRegistry $doctrine,Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $list_todo = new Todo();
        $list_todo->setName($request->request->get('name'));
        $list_todo->setDescription($request->request->get('des'));
        if(null !== $request->request->get('status')) {
            $list_todo->setStatus(true);
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
     * @Route("/list/update/{id}",name="viewUpdateTodo", methods={"GET"})
     */
    public function viewUpdateTodo(int $id): Response
    {
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (isset($list_todo)) {
            Response : CURLE_HTTP_NOT_FOUND;
        }
        return $this->render('todo/update.html.twig', ['item' => $list_todo]);
    }

       /**
     * @Route("/list/submit/{id}", name="submitUpdateTodo", methods={"POST"})
     */
    public function submitUpdateTodo(ManagerRegistry $doctrine, int $id,Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (isset($list_todo)) {
            Response : CURLE_HTTP_NOT_FOUND;
        }
         $list_todo->setName($request->request->get('name_update'));
         $list_todo->setDescription($request->request->get('des_update'));

         if(null !== $request->request->get('status_update')) {
            $list_todo->setStatus($request->request->get('status_update'));
        } else {
            $list_todo->setStatus(false);
        }

        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

     /**
     * @Route("/list/do/{id}",name="setCompleted", methods={"GET"})
     */
    public function setCompleted(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (isset($list_todo)) {
            Response : CURLE_HTTP_NOT_FOUND;
        }

        $list_todo->setStatus(true);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

     /**
     * @Route("/list/undo/{id}",name="setNotCompleted", methods={"GET"})
     */
    public function setNotCompleted(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (isset($list_todo)) {
            Response : CURLE_HTTP_NOT_FOUND;
        }
        
        $list_todo->setStatus(false);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

      /**
     * @Route("/list/delete/{id}",name="deleteTodo", methods={"GET"})
     */
    public function deleteTodo(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (isset($list_todo)) {
            Response : CURLE_HTTP_NOT_FOUND;
        }
        
        $entityManager->remove($list_todo);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
