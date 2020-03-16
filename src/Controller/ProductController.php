<?php


namespace App\Controller;


use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    /**
     * @Route("/product",name="product_list")
     */
    public function index() {
        $products = [
            new Product(1, "Laptop", 9000, 2, "Laptop", "placeholder image",
                new \DateTime('2017-10-17', new \DateTimeZone('Europe/Paris'))),
            new Product(2, "Machine a laver", 5000, 22, "Samsung", "placeholder image",
                new \DateTime('2017-10-17', new \DateTimeZone('Europe/Paris'))),
            new Product(3, "Iphones", 9000, 50, "Apple SmartPhones", "placeholder image",
                new \DateTime('2017-10-17', new \DateTimeZone('Europe/Paris')))
        ];
        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }


    /**
     * @return Response
     * @Route("/product/add",name="product_add")
     */
    public function add() {
        return $this->render('product/add.html.twig');
    }


    /**
     * @Route("/product/edit",name="product_edit")
     */
    public function edit() {
        return $this->render('product/edit.html.twig');
    }

    /**
     * @Route("/product/show",name="product_show")
     */
    public function show() {
        return $this->render('product/show.html.twig');
    }



}