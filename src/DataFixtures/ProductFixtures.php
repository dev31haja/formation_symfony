<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Repository\TypeProductRepository;
use App\Repository\CategoryRepository;
use App\Service\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private $slug;
    private $category_repo;
    private $type_product;

    public function __construct(Slugify $slug, CategoryRepository $cat_repo, TypeProductRepository $type_prod)
    {
        $this->slug = $slug;
        $this->category_repo = $cat_repo;
        $this->type_product = $type_prod;
    }

    public function load(ObjectManager $manager)
    {
        $all_cat = $this->category_repo->findAll();
        $all_types = $this->type_product->findAll();
        for($i = 0; $i <=40 ; $i++){
            $product = new Product();
            
            $product_name ='product '.$i;

            $product->setName($product_name);
            $product->setPrice(rand(3,50));
            $product->setDescription('product numéro '.$i);
            $product->setSlug($this->slug->slugify($product_name));

            
            $cat_id = $all_cat[rand(0,5)];
            $type_id = $all_types[rand(0,2)];
            
            $product->setCategory($cat_id);
            $product->setTypeProduct($type_id);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class, TypeProductFixtures::class];
    }
}
