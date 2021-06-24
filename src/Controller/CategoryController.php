<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends AbstractController
{
    private $logger;
    private $catRepo;

    public function __construct(LoggerInterface $logger, CategoryRepository $category_repo){
        $this->logger = $logger;
        $this->catRepo = $category_repo;
    }

    /**
     * @Route("/editCategory/{slug}", name="edit_category")
     * @ParamConverter("category", converter="CustomParamConverter")
     */
    public function editCategory(Request $request, Category $category)
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        //$category = $this->catRepo->find($id);
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $category = $form->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            
            return $this->redirectToRoute('product_list');
        }

        return $this->render('category/edit_category.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
