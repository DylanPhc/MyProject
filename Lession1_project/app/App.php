<?php 
declare(strict_types = 1);
function getTransactionFiles(string $dirPath): array{
    $files = [];
    foreach(scandir(FILES_PATH) as $file){
         if(is_dir($file)){
            continue;
         }

         $files[] = $dirPath. $file;
    }

    return $files;
}

function getTransaction(string $fileName, ?callable $transactionHandler = null): array{
    if(!file_exists($fileName)){
        trigger_error('File'.$fileName.'does not exist.', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');
    $transactions =  [];
    while (($transaction = fgetcsv($file)) != false){
        $transactions[] = extractTransaction($transaction) ;
    }
    return $transactions;
}

function extractTransaction(array $transactionRow) : array {
    [$date, $checkNumber, $description, $amount] = $transactionRow;
    $amount =(float) str_replace(['$',','], '', $amount);
    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];
}

function caculateTotals( array $transactions): array{
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' =>0];
    foreach($transactions as $transaction){
        $totals['netTotal'] += $transaction['amount'];
        if($transaction['amount'] < 0){
            $totals['totalExpense'] += $transaction['amount'];
        } else{
            $totals['totalIncome'] += $transaction['amount'];
        }
    }
    return $totals;
}