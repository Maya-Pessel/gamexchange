<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductType;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class ProductController extends AbstractController
{

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy([], ['id' => 'DESC']);

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
            $product -> setUser($this->security->getUser());
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


    /**
     * @Route("/product/{id<[0-9]+>}/edit", name="app_product_edit", methods="GET|POST")
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        if ($product->getUser() !== $this->security->getUser()) {
            throw $this->createAccessDeniedException('You are not the owner of this product');
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Product successfully updated');

            return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

}
