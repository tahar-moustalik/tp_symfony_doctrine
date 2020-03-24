<?php


namespace App\Service;


use App\Entity\OrderDetail;
use App\Repository\OrderDetailRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderDetailService
{

    private $manager;
    private $orderDetailRepository;
    private $utilsService;
    public function __construct(EntityManagerInterface $manager,
                                OrderDetailRepository $orderDetailRepository,
                                UtilsService $utilsService)
    {
        $this->manager = $manager;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->utilsService = $utilsService;
    }

    public function getAll()
    {
        return $this->orderDetailRepository->findAll();
    }


    public function find(int $id)
    {
        $orderDetail = $this->orderDetailRepository->find($id);
        if($orderDetail == null) {
            return $orderDetail;
        }
        return $orderDetail;
    }


    public function add(OrderDetail $orderDetail)
    {
        try {
            $this->manager->persist($orderDetail);
            $this->manager->flush();
            $this->utilsService->createFlashMessage(
                'success',
                        'Successfully Added ProductOrder'
            );
        }
        catch (\PDOException $e){
            $this->utilsService->createFlashMessage(
                'error',
                'Error Adding ProductOrder'
            );
        }
    }

    public function delete(int $id)
    {

        try
        {
            $orderDetail = $this->orderDetailRepository->find($id);
            $this->manager->remove($orderDetail);
            $this->manager->flush();
            $this->utilsService->createFlashMessage(
                'success',
                'Successfully Removed ProductOrder'
            );
        }
        catch (\PDOException $e)
        {
            $this->utilsService->createFlashMessage(
                'error',
                'Error Removing ProductOrder'
            );
        }
    }


    public function update(OrderDetail $orderDetail)
    {

        try {
            $this->manager->persist($orderDetail);
            $this->manager->flush();
            $this->utilsService->createFlashMessage(
                'success',
                'Successfully Updated ProductOrder'
            );
        }
        catch (\PDOException $e)
        {
            $this->utilsService->createFlashMessage(
                'error',
                'Error Updating ProductOrder'
            );
        }

    }
}