<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

//spendingsテーブルデータ全件取得
$sql = "select  * from spendings";
$statement = $pdo->prepare($sql);
$statement->execute();
$results1 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results1);

//１月の支出一覧表示
$sql = "select name, amount from spendings where accrual_date between '2022-01-01' and '2022-01-31'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results2);

echo "１月の支出" . "<br>";
foreach ($results2 as $result2) {
    echo $result2["name"] . ":" . $result2["amount"] . "<br>";
}
echo "<br>";

//２月の支出一覧表示
$sql = "select name, amount from spendings where accrual_date between '2022-02-01' and '2022-02-28'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results3 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "２月の支出" . "<br>";
foreach ($results3 as $result3) {
    echo $result3["name"] . ":" . $result3["amount"] . "<br>";
}
echo "<br>";

//３月の支出一覧表示
$sql = "select name, amount from spendings where accrual_date between '2022-03-01' and '2022-03-31'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results4 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "３月の支出" . "<br>";
foreach ($results4 as $result4) {
    echo $result4["name"] . ":" . $result4["amount"] . "<br>";
}
echo "<br>";

//日付順にsortして支出を一覧表示
$sql = "select name, amount from spendings order by accrual_date";
$statement = $pdo->prepare($sql);
$statement->execute();
$results5 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "日付順にsortして支出を一覧表示" . "<br>";
foreach ($results5 as $result5) {
    echo $result5["name"] . ":" . $result5["amount"] . "<br>";
}
echo "<br>";

//支出の高い順にsortして支出を一覧表示
$sql = "select amount from spendings order by amount DESC";
$statement = $pdo->prepare($sql);
$statement->execute();
$results6 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "支出の高い順" . "<br>";
foreach ($results6 as $result6) {
    echo $result6["amount"] . "<br>";
}
echo "<br>";

//支出の低い順にsortして支出を一覧表示
$sql = "select amount from spendings order by amount";
$statement = $pdo->prepare($sql);
$statement->execute();
$results7 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "収入の低い順" . "<br>";
foreach ($results7 as $result7) {
    echo $result7["amount"] . "<br>";
}
