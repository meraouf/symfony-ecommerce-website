<?php

namespace App\Controller;

use App\classe\Search;
use App\Entity\Products;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager ;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $products = $this->entityManager->getRepository(Products::class)->findWithSearch($search);
        } else {
            $products = $this->entityManager->getRepository(Products::class)->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form'=>$form->createView()
        ] );
    }

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Products::class)->findOneBySlug($slug);//on vient definir cette methode de recherche et SYMFONY sait bien que find one by slug que slug est propriete dans l'entity
        $products = $this->entityManager->getRepository(Products::class)->findByIsBest(true);
        
        if (!$product) {
            return $this->redirectToRoute('products'); // 'products' nom de la route
        }

        return $this->render('product/show.html.twig', [
            'product'=>$product,
            'products' => $products
        ] );
    }
}
