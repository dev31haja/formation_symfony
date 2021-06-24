<?php

namespace App\Form;
use App\Entity\Product;
use App\Entity\TypeProduct;
use App\Repository\CategoryRepository;
use Proxies\__CG__\App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', TextType::class)
            //->add('slug', TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $cat_rep) {
                    return $cat_rep->createQueryBuilder('c')
                        ->where('c.isEnabled = :enabled')
                        ->setParameter('enabled', true)
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'])
            ->add('typeProduct', EntityType::class, ['class' => TypeProduct::class,'choice_label' => 'name'])
            //->add('carts')
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
