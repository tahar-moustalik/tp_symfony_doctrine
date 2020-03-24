<?php


namespace App\Service;


use App\Entity\Product;
use App\Entity\Produit;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;


class ProductService
{

    private $manager;
    private $productRepository;
    private $utilsService;
    public function __construct(EntityManagerInterface $manager,
                                ProductRepository $productRepository,
                                UtilsService $utilsService)
    {
        $this->manager = $manager;
        $this->productRepository = $productRepository;
        $this->utilsService = $utilsService;
    }

    public function getAll() {
        return $this->manager->getRepository(Product::class)->findAll();
    }

    public function getLatestAddedProducts(int $limit) {
        return $this->manager->getRepository(Product::class)->findLatestAddedProduct($limit);
    }
    public function find($id):?Product{

        try {
           return $this->productRepository->find($id);
        }
        catch (\PDOException $e) {
            return null;
        }
    }

    public function delete($id):void {

        try {
            $product  = $this->find($id);
            $this->manager->remove($product);
            $this->utilsService->createFlashMessage(
                'success',
                'Successfully Deleted Produit'
            );
        }
        catch (\PDOException $e) {
            $this->utilsService->createFlashMessage(
                'error',
                'Error Deleting Produit'
            );
        }
    }

    public function update(Produit $product) {
        $this->utilsService->createFlashMessage(
            'success',
            'Successfully Updated Produit'
        );
    }


    public  function add(Product $product) {
        $this->manager->persist($product);
        $this->manager->flush();
       $this->utilsService->createFlashMessage(
           'success',
           'Successfully Added Produit'
       );
    }





}