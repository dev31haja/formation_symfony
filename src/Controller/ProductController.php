<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private $calco;

    public function __construct(Calculator $calculator){
        $this->calco = $calculator;    
    }

    public function list($page){
        // ...
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        
        return $this->render('product/index.html.twig',
            [
                'page' => $page,
                'products' => $products
            ]
        );
        //return new Response('<html><body> Liste Page num : '.$page.'</body></html>');
    }

    public function show(Request $request, $slug) {
        $product_data = $this->getDoctrine()->getRepository(Product::class)->findOneBySlug($slug);
        dump($product_data);
        return $this->render('product/product.html.twig',
            [
                'product' => $product_data,
                'val' => $this->calco->calculTva(10)
            ]
        );
        //return new Response('<html><body>Show : '.$slug.'</body></html>');
        // ...
    }
}