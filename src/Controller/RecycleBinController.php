<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/recyclebin")
 */
class RecycleBinController extends AbstractController {

    /**
     * @var TodoRepository
     */
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/index", name="recyclebin", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine) : Response {

        $repository = $doctrine->getRepository(Todo::class);
        $listDel = $repository->findBy(
                ['isActive' => false]
        );

        return $this->render('recycle-bin/index.html.twig', ['listDel' => $listDel]);
    }

    /**
     * @Route("/restore/{id}",name="restoreTask", methods={"GET"})
     */
    public function restoreTask(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $list_restore = $this->todoRepository->findOneBy(['id' => $id]);

        if (!isset($list_restore)) {
            Response :: HTTP_NOT_FOUND;
        }else{
            $list_restore->setIsActive(true);
            $entityManager->flush();
            Response :: HTTP_OK;
        }
        return $this->redirectToRoute('recyclebin');
    }

    /**
     * @Route("/resrowschecked",name="restoreRowsChecked", methods={"POST"})
     */
    public function delRowsChecked(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $list_todo = $this->todoRepository->findBy([
            'id' => explode(",", $request->request->get('emp_id'))
        ]);
        if(!empty($list_todo)){
            foreach ($list_todo as $item) {
                $item->setIsActive(true);
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