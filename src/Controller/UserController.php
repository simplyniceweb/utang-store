<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $em;
    private $users;

    public function __construct(EntityManagerInterface $em, UsersRepository $users)
    {
        $this->em = $em;
        $this->users = $users;
    }

    public function addUser(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $description = $request->get('description');

            $user = new Users();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setDescription($description);
            
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->redirectToRoute("index");
    }

    public function ajax(Request $request)
    {
        $keyword = $request->get('term');
        $results = $this->users->search($keyword);

        return new JsonResponse($results);
    }
}
