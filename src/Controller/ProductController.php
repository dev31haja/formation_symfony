<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Calculator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends AbstractController
{
    private $calco;
    private $logger;
    private $productRepo;

    public function __construct(Calculator $calculator, LoggerInterface $logger, ProductRepository $product_repo, CategoryRepository $category_repo){
        $this->calco = $calculator;    
        $this->logger = $logger;
        $this->productRepo = $product_repo;
    }

    public function list(){
        // ...
        $products = $this->productRepo->findAll();
        dump($this->getUser()->getCart());
        return $this->render('product/index.html.twig',
            [
                'products' => $products
            ]
        );
        //return new Response('<html><body> Liste Page num : '.$page.'</body></html>');
    }

    public function show(Request $request, $slug) {
        $product_data = $this->productRepo->findOneBy(['slug' => $slug]);
        return $this->render('product/product.html.twig',
            [
                'product' => $product_data,
                'val' => $this->calco->calculTva(10)
            ]
        );
        //return new Response('<html><body>Show : '.$slug.'</body></html>');
        // ...
    }


    public function addCartProduct($id){
        $manager = $this->getDoctrine()->getManager();
        
        $product= $this->productRepo->find($id);
        $cart = $this->getUser()->getCart();
        
        $cart->addProduct($product);

        $manager->persist($cart);
    
        $manager->flush();
        $encoder = new JsonEncoder();

        $default_context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object, $format, $context){
                return $object->getId();
            },
        ];

        $normalizer = new ObjectNormalizer(null,null,null,null,null,null,$default_context);
        $serializer = new Serializer([$normalizer], [$encoder]);

        $jsonContent = $serializer->serialize($cart, 'json');
        return new JsonResponse(["cart" => $jsonContent]);
    }
    
    public function editProduct(Request $request, $id){
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $product= $this->productRepo->find($id);
        $form = $this->createForm(ProductType::class, $product);
        
        /*
        // autre option : 
        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class)
            // ...
            ->getForm();
        */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/edit_product.html.twig',[
            'form' => $form->createView()
        ]);
    }

    public function createProduct(Request $request){
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();
            
            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/edit_product.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Fonction de log out
     */
    public function logOut(){
        //empty
    }
}