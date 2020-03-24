<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\Produit;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    public function __construct()
    {
    }

    /**
     * @Route("/product",name="product_list")
     * @param ProductService $productService
     * @return Response
     */
    public function index(ProductService $productService,EntityManagerInterface $em) {
        $products = $em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);

    }


    /**
     * @Route("/product/add",name="product_add_form",methods={"GET"})
     */
    public function showAddProductFrom() {

        return $this->render('product/add.html.twig');
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return Response
     * @Route("/product/add",name="product_add",methods={"POST"})
     * @throws Exception
     */
    public function add(Request $request,ProductService $productService) {
            $product = new Product();
            $product->setName($request->get('name'));
            $product->setDescription($request->get('description'));
            $product->setPrice($request->get('price'));
            $product->setImageUrl($request->get('imageUrl'));
            $product->setQuantity($request->get('quantity'));
            $product->setCreatedAt(new \DateTime('now'));
            $productService->add($product);
            return $this->redirectToRoute('product_list');
    }


    /**
     * @Route("/product/edit/{id}",name="product_edit")
     * @param $id
     * @param ProductService $productService
     * @return Response
     */
    public function edit($id,ProductService $productService) {

        $product = $productService->find($id);
        if($product == null) {
            throw $this->createNotFoundException("Produit with id ".$id . "is not found");
        }
        else {
            return $this->render('product/edit.html.twig',[
                'product' => $product
            ]);
        }
    }


    /**
     * @param Request $request
     * @param ProductService $productService
     * @param Session $session
     * @return RedirectResponse
     * @Route("/product/update",name="product_update",methods={"POST"})
     */
    public function update(Request $request,ProductService $productService,Session $session) {

        $product = $productService->find($request->get('id'));
        if($product != null) {
            $product->setName($request->get('name'));
            $product->setQuantity($request->get('quantity'));
            $product->setPrice($request->get('price'));
            $product->setDescription($request->get('description'));
            $product->setImageUrl($request->get('imageUrl'));
            $productService->update($product);
        }
        else {
            $session->getFlashBag()->add(
                'error',
                'Error Updating Produit'
            );
        }
        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/product/show/{id}",name="product_show")
     * @param $id
     * @param ProductService $productService
     * @return Response
     */
    public function show($id,ProductService $productService) {

        $product = $productService->find($id);
        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }


    /**
     * @param $id
     * @param ProductService $productService
     * @Route("/product/{id}",name="product_delete",methods={"GET"})
     * @return RedirectResponse
     */
    public function delete($id,ProductService $productService){
        $productService->delete($id);
        return $this->redirectToRoute('product_list');
    }


    /**
     * @param int $id
     * @param ProductService $productService
     * @return Response
     * @Route("/product/order/details/{id}",name="product_order_details",methods={"GET"})
     */
    public function productOrderDetails(int $id,ProductService $productService){
        $product = $productService->find($id);
         return $this->render('product/order_details.html.twig',[
             'product_name' => $product->getName(),
             'orderDetails' => $product->getOrderDetails()
         ]);

    }


    /**
     * @Route("/product/latest/3",name="product_latest_3",methods={"GET"})
     * @param ProductService $productService
     * @return Response
     */
    public function lastThreeAddProducts(ProductService $productService) {
        $products = $productService->getLatestAddedProducts(3);
        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }



}