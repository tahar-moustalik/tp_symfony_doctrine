<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\OrderDetail;
use App\Service\OrderDetailService;
use App\Service\OrderService;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    const QUANTITY = 1;
    const PRODUCT_ID = 0;

    /**
     * @Route("/order", name="order_index")
     * @param OrderService $orderService
     * @return Response
     */
    public function index(OrderService $orderService)
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderService->getAll(),
        ]);
    }

    /**
     * @Route("/order/add", name="order_add_form",methods={"GET"})
     * @param ProductService $productService
     * @return Response
     */
    public function showOrderAddForm(ProductService $productService)
    {
        $products =  $productService->getAll();
        return $this->render('order/add.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/order/add", name="order_add",methods={"POST"})
     * @param Request $request
     * @param ProductService $productService
     * @param OrderService $orderService
     * @return Response
     */
    public function add(Request $request,ProductService $productService,OrderService $orderService)
    {
        $data = $request->request->all();
        $selectedProducts = $data['ligneCmds'];
       $order = new ProductOrder();
        for ($i=0; $i< count($selectedProducts);$i++) {
            $selectedProduct = explode('-',$selectedProducts[$i]);
            $orderDetail = new OrderDetail();
            $orderDetail->setQuantity($selectedProduct[self::QUANTITY]);
            $product = $productService->find($selectedProduct[self::PRODUCT_ID]);
            $orderDetail->setProduct($product);
            $order->addOrderDetail($orderDetail);
        }
        $orderService->add($order);
        return $this->redirectToRoute('order_index');

    }

    /**
     * @Route("/order/{id}",name="order_show",methods={"GET"})
     * @param int $id
     * @param OrderService $orderService
     * @return Response
     */
    public function show(int $id,OrderService $orderService){

        $order = $orderService->find($id);

        return $this->render('order/show.html.twig',[
            'order' => $order
        ]);

    }

    /**
     * @Route("/order/edit/{id}", name="order_edit",methods={"GET"})
     */
    public function edit()
    {
        return $this->render('order_detail/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/order/update", name="order_update",methods={"POST"})
     */
    public function update()
    {
        return $this->render('order_detail/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/order/{id}", name="order_delete",methods={"GET"})
     * @param int $id
     * @param OrderDetailService $orderDetailService
     * @return void
     */
    public function delete(int $id,OrderDetailService $orderDetailService)
    {
        $orderDetailService->delete($id);
    }



}
