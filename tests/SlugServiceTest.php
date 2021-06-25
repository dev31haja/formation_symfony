<?php

namespace App\Tests;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SlugServiceTest extends WebTestCase
{
    
    private $slugify_service;
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;
        
        $this->slugify_service = $container->get('App\Service\Slugify');
    }

    public function testSomething(): void
    {
        $category = new Category();
        $name = 'myTest 1';
        $category->setName($name);
        $category->setSlug($this->slugify_service->slugify($name));


        $slug = $category->getSlug();
        $this->assertTrue($slug === 'mytest-1');
    }
}
