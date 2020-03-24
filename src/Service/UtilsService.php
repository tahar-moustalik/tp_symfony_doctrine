<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class UtilsService
{

    /**
     * @var SessionInterface
     */
    private  $session;

    public function __construct()
    {
        $this->session = new Session(new NativeSessionStorage(),new NamespacedAttributeBag());
    }

    public function createFlashMessage(string $type,string $message):void {
        $this->session->getFlashBag()->add(
            $type,
            $message
        );
    }

}