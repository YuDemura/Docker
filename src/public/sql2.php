<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

//incomesテーブル
$sql = "select sum(amount) from incomes";
$statement = $pdo->prepare($sql);
$statement->execute();
$result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result1);

//spendingsテーブル
$sql = "select sum(amount) from spendings";
$statement = $pdo->prepare($sql);
$statement->execute();
$result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($result2);

echo "incomesテーブルのamountカラムの合計:" . $result1[0]["sum(amount)"] . "<br>" . "spendingsテーブルのamountカラムの合計:" . $result2[0]["sum(amount)"];
