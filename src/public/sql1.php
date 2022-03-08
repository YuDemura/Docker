<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

//incomesテーブルデータ
$sql = "select * from incomes";
$statement = $pdo->prepare($sql);
$statement->execute();
$result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($result1);

//spendingsテーブルデータ
$sql = "select * from spendings";
$statement = $pdo->prepare($sql);
$statement->execute();
$result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($result2);


//categoriesテーブルデータ
$sql = "select * from categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$result3 = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($result3);
