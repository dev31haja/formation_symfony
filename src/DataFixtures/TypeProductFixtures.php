<?php

namespace App\DataFixtures;

use App\Entity\TypeProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = [
            ['classical_goods','Biens et services classiques',20],
            ['natural_goods','produits agricoles non transfo, bois, travaux logement',10],
            ['food','produits alimentaires, énergies, repas, culture',5.5],
        ];
        for($i = 0; $i <count($types) ; $i++){
            $type = new TypeProduct();
            $type->setName($types[$i][0]);
            $type->setLabel($types[$i][1]);
            $type->setTva($types[$i][2]); 
            
            $manager->persist($type);
        }
        $manager->flush();
    }
}
