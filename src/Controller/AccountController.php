<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends AbstractController {

    /**
     * @var AccountRepository
     */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository){
        $this->accountRepository = $accountRepository;
    }
    /**
     * @Route("/log", name="log", methods={"POST"})
     */
    public function login(Request $request) {

        $user = $this->accountRepository->findOneBy([
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password')
        ]);
        
        if(isset($user))
        {
         $_SESSION['username']=$user->getUsername();
         echo "success";
        }
        else
        {
         echo "fail";
        }
        exit();
    }  
}
