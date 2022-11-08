<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;
use App\Entity\Headers;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em) {
        $this->entityManager = $em;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $headers = $this->entityManager->getRepository(Headers::class)->findAll();
        $products = $this->entityManager->getRepository(Products::class)->findByIsBest(1);
        
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'headers' =>   $headers
        ]);
    }
}
