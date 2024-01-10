<?php

declare(strict_types = 1);

$root = dirname(__DIR__).DIRECTORY_SEPARATOR;

define('APP_PATH', $root.'app'.DIRECTORY_SEPARATOR);
define('FILES_PATH', $root.'transaction_file'.DIRECTORY_SEPARATOR);
define('VIEW_PATH', $root.'view'.DIRECTORY_SEPARATOR);


require APP_PATH."App.php";
require APP_PATH."helper.php";

$files = getTransactionFiles(FILES_PATH);

$transactions = [];
foreach($files as $file){
    $transactions = array_merge($transactions, getTransaction($file, 'extractTransaction'));
}
$totals = caculateTotals($transactions);
require VIEW_PATH.'transaction.php';