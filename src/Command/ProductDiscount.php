<?php
namespace App\Command;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ProductDiscount extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'product:discount';
    private $product_repo;
    private $entity_mananger;
    
    protected function configure(): void
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Discount on prices.')
        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Apply discount on products')
        ->addArgument('amount', InputArgument::REQUIRED, 'The username of the user.')
        ->addOption(
            'category',
            null,
            InputOption::VALUE_REQUIRED,
            'Choose the category (id) : [19]',
            19
        );
    }

    public function __construct(ProductRepository $product_repo, string $name='', EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->product_repo = $product_repo;
        $this->entity_mananger = $entityManager;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $products = $this->product_repo->findBy(['category' => $input->getOption('category')]);
        $discount = 1 - (floatval($input->getArgument('amount')) / 100);
        
        foreach($products as $product){
            $product->setPrice($product->getPrice() * $discount);
            $output->writeln($product->getName().' ('.$product->getCategory()->getName().') New price = '.$product->getPrice()." €");
            $this->entity_mananger->persist($product);
        }

        $this->entity_mananger->flush();
        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }
}