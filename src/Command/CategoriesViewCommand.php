<?php

namespace App\Command;

use App\Services\FileManagementService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CategoriesViewCommand extends Command
{
    public function __construct(private FileManagementService $fileManagementService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("view:categories")
            ->setDescription("View all the categories that you are already added");
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $categories = $this->fileManagementService->getCategories();

        $io->listing($categories);
        
        return Command::SUCCESS;
    }


}
