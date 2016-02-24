<?php

namespace Smile\TrainingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * List products.
 * This command is intentionally not a service.
 */
class ProductListingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('training:products:list')
            ->setDescription('List training products');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getContainer()->has('product.provider')) {
            $output->writeln('<error>Service "product.provider" does not exist.</error>');

            return;
        }

        $productProvider = $this->getContainer()->get('product.provider');

        $table = new Table($output);
        $table->setHeaders(['Id', 'Name', 'Price']);

        foreach ($productProvider->getAll() as $product) {
            $table->addRow([$product->getId(), $product->getName(), $product->getPrice()]);
        }

        $table->render();
    }
}
