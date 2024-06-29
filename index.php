<?php

require_once __DIR__."/vendor/autoload.php";

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Command\IncomeAddCommand;
use App\Command\ExpenseAddCommand;
use App\Command\IncomesViewCommand;
use App\Command\SavingsViewCommand;
use App\Services\FileManagementService;
use App\Command\ExpensesViewCommand;
use App\Command\CategoriesViewCommand;

$app =new Application();

$fileManagementService=new FileManagementService(
    __DIR__."/database/incomes.json",
    __DIR__."/database/expenses.json",
    __DIR__."/database/categories.json"
);

$app->add(new IncomeAddCommand($fileManagementService));
$app->add(new ExpenseAddCommand($fileManagementService));
$app->add(new IncomesViewCommand($fileManagementService));
$app->add(new ExpensesViewCommand($fileManagementService));
$app->add(new SavingsViewCommand($fileManagementService));
$app->add(new CategoriesViewCommand($fileManagementService));

$io = new SymfonyStyle(new ArgvInput(), new ConsoleOutput());

$io->title('Income & Expense Management Cli Application');

while (true) {
    $io->text('Please select an option by typing this command:');
    $selection = $io->choice('Choose a command below', [
        'add:income' => 'You can add income by typing add:income',
        'add:expense' => 'You can add expense by typing add:expense',
        'view:income' => 'You can view incomes by typing view:income',
        'view:expense' => 'you can view expenses by typing view:expense',
        'view:savings' => 'You can view savings by typing view:savings',
        'view:categories' => 'You can view categories by typing view:categories',
        'exit'=>'Exit from this application or type ctrl + C'
    ]);

    if ($selection === 'exit') {
        $io->success('Successfully Exit from Income & Expense Management Cli Application.');
        break; 
    }

    $commandInput = new ArrayInput(['command' => $selection]);

    try {
        $app->doRun($commandInput, new ConsoleOutput());
        $io->success('Command Successfully Executed!');
    } catch (Exception $e) {
        $io->error('Something went wrong!: ' . $e->getMessage());
    }
}

