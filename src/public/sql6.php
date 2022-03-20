<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

$sql = "select
            month(accrual_date) as accrual_time, sum(amount)
        from
            incomes
        group by
            accrual_time";
$statement = $pdo->prepare($sql);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "前月の収入との差分を一覧表示してください。" . "<br>";
for ($i = 0; $i < 12; $i++) {
    if ($i == 0) {
        continue;
    }
    $diffAmount = abs($results[$i]["sum(amount)"] - $results[$i - 1]["sum(amount)"]);
    echo $i . "月と" . ($i + 1) . "月の差分: " . $diffAmount . "円" . "<br>";
}

$sql = "select
            month(accrual_date) as accrual_time, sum(amount)
        from
            spendings
        group by
            accrual_time";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<br>";
echo "前月の支出との差分を一覧表示してください。" . "<br>";
for ($x = 0; $x < 12; $x++) {
    if ($x == 0) {
        continue;
    }
    $diffAmount2 = abs($results2[$x]["sum(amount)"] - $results2[$x - 1]["sum(amount)"]);
    echo $x . "月と" . ($x + 1) . "月の差分: " . $diffAmount2 . "円" . "<br>";
}
