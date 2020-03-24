<?php


namespace App\Service;


use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Repository\OrderDetailRepository;
use App\Repository\ProductOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{

    private $manager;
    private $orderRepository;
    private $utilsService;
    public function __construct(EntityManagerInterface $manager,
                                ProductOrderRepository $orderRepository,
                                UtilsService $utilsService)
    {
        $this->manager = $manager;
        $this->orderRepository = $orderRepository;
        $this->utilsService = $utilsService;
    }


    public  function  getAll() {
        return $this->manager->getRepository(ProductOrder::class)->findAll();
    }


    public function add(ProductOrder $order) {
        $productAvailableQuantities = "Quantités Restantes des Produits <br>";
        try {
            foreach ($order->getOrderDetails() as $orderDetail) {
              $productAvailableQuantities .=  $this->updateAvailableQuantity($orderDetail->getProduct(),$orderDetail->getQuantity());
            }
            $this->manager->persist($order);
            $this->manager->flush();
            $this->utilsService->createFlashMessage(
                'success',
                'Successfully Added ProductOrder <br>'.
                $productAvailableQuantities
            );
        }
        catch (\PDOException $e){
            $this->utilsService->createFlashMessage(
                'error',
                'Error Adding ProductOrder'
            );
        }
    }

    public function find(int $id)
    {
        $order = $this->manager->getRepository(ProductOrder::class)->find($id);
        if($order == null) {
            return $order;
        }
        return $order;
    }


    public function updateAvailableQuantity(Product $product,int $quantityToSubstract){
        $product->setQuantity($product->getQuantity() - $quantityToSubstract);
        $this->manager->persist($product);
        $this->manager->flush();

        return $product->getName() . "---" . $product->getQuantity() ."<br>";
    }


}