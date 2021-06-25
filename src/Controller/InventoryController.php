<?php

namespace App\Controller;

use App\Entity\Inventory;
use App\Forms\InventoryType;
use App\Repository\InventoryRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InventoryController extends AbstractController
{
    private $em;
    private $inventory;

    public function __construct(EntityManagerInterface $em, InventoryRepository $inventory)
    {
        $this->em = $em;
        $this->inventory = $inventory;
    }

    public function index(Request $request, int $id = null)
    {
        $return = [
            'list' => []
        ];

        if (!$id) {
            $inventory = new Inventory();
        } else {
            $return['item'] = $inventory = $this->inventory->findOneBy([
                'id' => $id,
                'view_status' => 5
            ]);
        }
        
        $form = $this->createForm(InventoryType::class, $inventory);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTime("now");
            $data = $form->getData();

            $data->setCreatedAt($now);
            $data->setModifiedAt($now);
            $data->setViewStatus(5);

            $this->em->persist($data);
            $this->em->flush();

            return $this->redirectToRoute('inventory', ['id' => $data->getId()]);
        } else {
            if (!$id) {
                $return['list'] = $this->inventory->findBy(['view_status' => 5], ['created_at' => 'DESC'], 10);
            }
        }

        $return['form'] = $form->createView();
        
        $form2 = $this->createForm(InventoryType::class, (new Inventory()));
        $return['form_add'] = $form2->createView();
        
        return $this->render("inventory/inventory.twig", $return);
    }

    public function ajax(Request $request)
    {
        $keyword = $request->get('term');
        $results = $this->inventory->search($keyword);

        return new JsonResponse($results);
    }
}
