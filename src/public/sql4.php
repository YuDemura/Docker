<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

//incomesテーブルデータ全件取得
$sql = "select * from incomes";
$statement = $pdo->prepare($sql);
$statement->execute();
$results1 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results1);

//４月の収入の合計出力
$sql = "select
            DATE_FORMAT(accrual_date, '%Y-%m') as accrual_time, sum(amount)
        from
            incomes
        group by
            accrual_time";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results2);

echo "4月の収入の合計:" . $results2[3]["sum(amount)"];
echo "<br>";

//５月の収入の合計出力
echo "5月の収入の合計:" . $results2[4]["sum(amount)"];
echo "<br>";

//６月の収入合計出力
echo "6月の収入の合計:" . $results2[5]["sum(amount)"];
echo "<br>";

//月順にsortして月ごとの収入の合計を一覧表示
$sql = "select
            MONTH(accrual_date) as accrual_time, sum(amount)
        from
            incomes
        group by
            accrual_time";
$statement = $pdo->prepare($sql);
$statement->execute();
$results3 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results3);
echo "<br>";
echo "月順にsortして月ごとの収入の合計を一覧表示" . "<br>";
foreach ($results3 as $result3) {
    echo $result3["accrual_time"] . "月: ";
    echo $result3["sum(amount)"];
    echo "<br>";
}

//収入の高い順にsortして月ごとの収入の合計を一覧表示
$sql = "select
            MONTH(accrual_date) as accrual_time, sum(amount)
        from
            incomes
        group by
            accrual_time
        order by
            sum(amount) desc";
$statement = $pdo->prepare($sql);
$statement->execute();
$results4 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results4);
echo "<br>";
echo "収入の高い順にsortして月ごとの収入の合計を一覧表示" . "<br>";
foreach ($results4 as $result4) {
    echo $result4["accrual_time"] . "月: ";
    echo $result4["sum(amount)"];
    echo "<br>";
}

//収入の低い順にsortして月ごとの収入の合計を一覧表示
$sql = "select
            MONTH(accrual_date) as accrual_time, sum(amount)
        from
            incomes
        group by
            accrual_time
        order by
            sum(amount)";
$statement = $pdo->prepare($sql);
$statement->execute();
$results5 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results4);
echo "<br>";
echo "収入の低い順にsortして月ごとの収入の合計を一覧表示" . "<br>";
foreach ($results5 as $result5) {
    echo $result5["accrual_time"] . "月: ";
    echo $result5["sum(amount)"];
    echo "<br>";
}
