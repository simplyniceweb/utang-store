<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Users;
use App\Entity\DebtItem;

use App\Repository\DebtRepository;
use App\Repository\UsersRepository;
use App\Repository\DebtItemRepository;
use App\Repository\InventoryRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DebtController extends AbstractController
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

    public function overviewDebt(UsersRepository $ur, DebtRepository $dr, DebtItemRepository $dir, Request $request, int $id)
    {
		$debtor = $ur->find($id);

        return $this->render("credit/debt.overview.twig", [
			'debtor' => $debtor,
		]);
    }

    public function addDebt(UsersRepository $ur, Request $request)
    {
        // add debt
        if ($request->isMethod('POST')) {
        	$total = 0;
        	$user = (int) $request->get('name');
        	$item = $request->get('item');
        	$amount = $request->get('amount');
        	$price = $request->get('price');
        	$cash = $request->get('cash');
        	$desc = $request->get('desc');

        	if (!empty($price)) {
        		
        		$debt = new Debt();
        		$now = new \DateTime("now");

                $user = $ur->find($user);
                
                if (is_object($user)) {
                    $debt->setUser($user);
                }

        		$debt->setCreatedAt($now);
        		$debt->setModifiedAt($now);
        		$debt->setViewStatus(5);

	        	foreach ($price as $key => $p) {
	        		if (!$key || !isset($item[$key]) || !isset($amount[$key]) || !isset($price[$key])) {
	        			continue;
	        		}

	        		$i = (int) $item[$key];
	        		$a = (int) $amount[$key];
	        		$p = (float) $price[$key];

	        		$itemData = $this->inventory->findOneBy(['id' => $i, 'view_status' => 5]);

	        		$debtItem = new DebtItem();
					$debtItem->setItemName($itemData->getName());
					$debtItem->setAmount($a);
					$debtItem->setPrice($p);

		            $this->em->persist($debtItem);
		            $this->em->flush();

		            $debt->addDebtItem($debtItem);

	        		$total += ($a*$p);
	        	}

	        	$debt->setTotal($total);
				
				$this->em->persist($debt);
				$this->em->flush();
        	}

			if ($cash) {
				if (!isset($debt)) {
					$debt = new Debt();
					$now = new \DateTime("now");

					$debt->setCreatedAt($now);
					$debt->setModifiedAt($now);
					$debt->setViewStatus(5);
				}


				$debt->setCash($cash);
				$debt->setTotal($cash);
				$debt->setDescription($desc);
				
				$this->em->persist($debt);
				$this->em->flush();
			}
        }

        return $this->redirectToRoute('index');
    }

    public function editDebt(?int $id, Request $request)
    {
        $return = [];
        return $this->render("credit/edit.credit.twig", $return);
    }

	public function deleteDebt(?int $id, int $user_id, Request $request)
	{
		$now = new \DateTime("now");
		$debt = $this->debt->find($id);

		$debt->setViewStatus(1);
		$debt->setModifiedAt($now);
				
		$this->em->persist($debt);
		$this->em->flush();

        return $this->redirectToRoute('overview-debt', ['id' => $user_id]);
	}

    public function payDebt(int $id, int $user_id, Request $request)
    {
    	$amount = (float) $request->get('pay_amount');

    	if (!$amount) {
    		return $this->redirectToRoute('overview-debt', [
    			'id' => $user_id
    		]);
    	}

    	$now = new \DateTime('now');

    	$debt = $this->debt->find($id);
    	
    	if (is_object($debt)) {
    		$paid = (float) $debt->getPaidAmount();
            $total = ($paid+$amount);

			$debt->setPaidAmount($total);
			$debt->setPaidAt($now);
			$debt->setModifiedAt($now);

            if ($total >= $debt->getTotal()) {
                $debt->setViewStatus(3);
            }

			$this->em->persist($debt);
			$this->em->flush();
		}

		return $this->redirectToRoute('overview-debt', [
			'id' => $user_id
		]);
    }
}
