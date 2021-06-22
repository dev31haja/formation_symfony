<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $slug;

    public function __construct(Slugify $slug)
    {
        $this->slug = $slug;
    }

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i <=5 ; $i++){
            $category = new Category();
            $cat_name = 'cat '.$i;
            $category->setName($cat_name);
            $cat_slug = $this->slug->slugify($cat_name);
            $category->setSlug($cat_slug);
            
            $manager->persist($category);
        }

        $manager->flush();
    }
}
