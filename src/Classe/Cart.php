<?php

namespace App\Classe;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart

{
    private $requestStack;
    private $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;

    }

    public function add($id)
    {
        $session = $this->requestStack->getSession();
         $cart= $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
     

        $session->set('cart', $cart);
    }










    public function remove()
    {
        $session = $this->requestStack->getSession();
        return $session->remove('cart');
    }




    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart',[]);
        unset($cart[$id]);
        return $session->set('cart',$cart);
    }



    public function removeOne($id)
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart',[]);


        if( $cart[$id]>1 ){

            $cart[$id]--;

        }else{
            unset($cart[$id]);
        }

        return $session->set('cart',$cart);
    }





    public function get()
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart');
    }

    public function getFull()
    {

        $cartComplete = [];

        if ($this->get() == null) {
        } else {
            foreach ($this->get() as $id => $quantity) {
                
                $productobjet=$this->productRepository->findOneById($id);
                
                if (!$productobjet) {
                   $this->delete($id);
                   continue;
                }

                $cartComplete[] = [
                    'product' => $productobjet,
                    'quantity' => $quantity
                ];
            };
        }

        return $cartComplete;

       
    }

}
