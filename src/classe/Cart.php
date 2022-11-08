<?php

namespace App\classe;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);    // soit il ya qlq produits dans panier , soit retourne ARRAY vide
        if (!empty($cart[$id]))                             // l'article qui est dans panier avec 'id' précis
        {
            $cart[$id]++;                                     // s'il existe on incrémente
        } else {
            $cart[$id] = 1;                                     // premier ajout  si n'etait pas ajouté avant
        }

        $this->session->set('cart', $cart );
    }


    public function get()
    {
        return $this->session->get('cart');
    }


    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart',[]);
        unset($cart[$id]);
        return $this->session->set('cart', $cart );
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]-- ;
        } else {
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

    public function getFull()
    {
        $cartComplete = [];
        if ($this->get()) {
            foreach ($this->get() as $id=>$quantity) {
                $product_object = $this->entityManager->getRepository(Products::class)->findOneById($id);

                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete [] = [
                    'product'=>$product_object,
                    'quantity'=>$quantity
                ];
            }
        }
        return $cartComplete;
    }


}