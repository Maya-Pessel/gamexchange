<?php

use App\Entity\Product;
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('/index.html.twig', [
            'products' => $products
        ]);
    }
        /**
     * @Route("/create", name="app_create_product", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product;

        $form = $this -> createForm(ProductType::class, $product);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // $product -> setUser($this->security->getUser());
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Product successfully created');

            return $this->redirectToRoute("app_home");
        }

        return $this -> render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

/**
     * @Route("/product/{id<[0-9]+>}", name="app_product_show", methods="GET|POST")
     */

    public function show(Product  $product, Request $request, EntityManagerInterface $em ): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }


}
