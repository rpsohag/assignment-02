<?php

namespace App\Command;

use App\Services\FileManagementService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SavingsViewCommand extends Command
{
    public function __construct(private FileManagementService $fileManagementService)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("view:savings")
        ->setDescription("View total savings");
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $incomes = $this->fileManagementService->getIncomes();
        $expenses = $this->fileManagementService->getExpenses();

       $totalIncome=array_reduce($incomes,function($carry,$income){
        return $carry + $income->getAmount();
       },0);

       $totalExpense=array_reduce($expenses,function($carry,$expense){
        return $carry + $expense->getAmount();
       },0);

       $savings=$totalIncome-$totalExpense;

       $io->success("Your total savings: {$savings}");


        return Command::SUCCESS;
    }


}
