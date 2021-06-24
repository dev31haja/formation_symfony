<?php
namespace App\ParamConverter;

use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class CustomParamConverter implements ParamConverterInterface{
    private $catRepo;
    public function __construct(CategoryRepository $catRepo)
    {
        $this->catRepo = $catRepo;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $category = $this->catRepo->findOneBy(['slug' => $request->get('slug')]);
        $request->attributes->set($configuration->getName(), $category);
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getName() === 'category';
    }
}