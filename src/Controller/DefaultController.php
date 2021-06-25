<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Users;
use App\Entity\DebtItem;

use App\Repository\DebtRepository;
use App\Repository\UsersRepository;
use App\Repository\InventoryRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    private $em;
    private $debt;
    private $inventory;

    public function __construct(EntityManagerInterface $em, InventoryRepository $inventory, DebtRepository $debt)
    {
        $this->em = $em;
        $this->debt = $debt;
        $this->inventory = $inventory;
    }

    public function index(Request $request)
    {
        $return = [];

        // 5 recent debts
        $return['recents'] = $this->debt->findBy(['view_status' => 5], ['created_at' => 'DESC'], 5, 0);
        
        return $this->render("index.twig", $return);
    }

    public function search(Request $request)
    {
        $type = $request->get('type');
        $keyword = $request->get('keyword');
        $repo = $type === 'inventory' ? $this->inventory : $this->debt;

        $results = $repo->search($keyword);

        return $this->render("search.twig", [
            'type' => $type,
            'results' => $results
        ]);
    }
}
