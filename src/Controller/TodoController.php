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

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/todo", name= "createTodo", methods={"POST"})
     */
    public function createTodo(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $list_todo = new Todo();
        $list_todo->setName($request->request->get('name'));
        $list_todo->setDescription($request->request->get('des'));

        // tell Doctrine you want to (eventually) save the Todo (no queries yet)
        $entityManager->persist($list_todo);

        // the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/list/submit", name="submitUpdateTodo", methods={"POST"})
     */
    public function submitUpdateTodo(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $request->get('id_update')]);

        if (!isset($list_todo)) {
            return new Response(
                'fail',
                Response::HTTP_NOT_FOUND
            );
        }else{
            $list_todo->setName($request->request->get(trim('name_update')));
            $list_todo->setDescription($request->request->get(trim('des_update')));

            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/list/do/{id}",name="setCompleted", methods={"GET"})
     */
    public function setCompleted(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (!isset($list_todo)) {
            return new Response(
                'fail',
                Response::HTTP_NOT_FOUND
            );
        }
        else {
            $list_todo->setStatus(true);
            $entityManager->flush();  

            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/list/undo/{id}",name="setNotCompleted", methods={"GET"})
     */
    public function setNotCompleted(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (!isset($list_todo)) {
            return new Response(
                'fail',
                Response::HTTP_NOT_FOUND
            );
        }else{
            $list_todo->setStatus(false);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/list/delete/{id}",name="deleteTodo", methods={"GET"})
     */
    public function deleteTodo(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findOneBy(['id' => $id]);

        if (!isset($list_todo)) {
            return new Response(
                'fail',
                Response::HTTP_NOT_FOUND
            );
        }else{
            $list_todo->setIsActive(false);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/list/delete/rowschecked",name="delRowsChecked", methods={"POST"})
     */
    public function delRowsChecked(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        //dump($request->request);
        //die;
        $list_todo = $this->todoRepository->findBy([
            'id' => explode(",", $request->request->get('emp_id'))
        ]);
        if(!empty($list_todo)){
            foreach ($list_todo as $item) {
                $item->setDeletionTimeValue();
                $item->setIsActive(false);
            }
            $entityManager->flush();
            return new Response(
                'success',
                Response::HTTP_OK
            );
        }else{
            return new Response(
                'fail',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
