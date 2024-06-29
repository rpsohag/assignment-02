<?php

namespace App\Command;

use App\Services\FileManagementService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IncomesViewCommand extends Command
{
    public function __construct(private fileManagementService $fileManagementService)
    {
        parent::__construct();
    }


    protected function configure()
    {
        $this->setName("view:income")
            ->setDescription("You can see all incomes that you have already added");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $incomes = $this->fileManagementService->getIncomes();

        $tableData = array_map(
            function ($income) {
                return [$income->getAmount(), $income->getCategory(), $income->getDate()];
            },
            $incomes
        );

        $io->table(["Amount","Category","Date"],$tableData);


        return Command::SUCCESS;
    }
}
