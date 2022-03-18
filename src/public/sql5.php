<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

$sql = "select
            date_format(accrual_date, '%m%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '07'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $result) {
    $amount = (int)$result["amount"];
    if (strpos($result["date_time"], '2') !== false ) {
        $amount -= 1000;
    }
    $sum += $amount;
}
echo "７月の支出の合計：" . $sum;
echo "<br>";

$sql = "select
            date_format(accrual_date, '%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '08'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($results2 as $result2) {
    $amount2 = (int)$result2["amount"];
    if (substr($result2["date_time"], -1) == 0) {
        $amount2 -= 500;
    }
    $sum2 += $amount2;
}
echo "8月の支出の合計：" . $sum2;
echo "<br>";

$sql = "select
            date_format(accrual_date, '%m%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '09'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results3 = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($results3 as $result3) {
    $amount3 = (int)$result3["amount"];
    if (strpos($result3["date_time"], '1') !== false ) {
        $amount3 -= 2000;
    }
    $sum3 += $amount3;
}
echo "9月の支出の合計：" . $sum3;
echo "<br>";

$sql = "select * from spendings";
$statement = $pdo->prepare($sql);
$statement->execute();
$results4 = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($results4 as $result4) {
    $dateAmountList[$result4["accrual_date"]] += $result4["amount"];
    $totalDateList[] = $result4["accrual_date"];
}

$countFive = count($totalDateList);
for ($i = 0; $i < $countFive; $i++) {
    if (substr($totalDateList[$i], -1) == 5) {
        $get = substr($totalDateList[$i], 5, 2);
        $reduceList[] = $get;
    }
}

$reduceCountList = array_count_values($reduceList);
foreach ($reduceCountList as $reduceMonth => $reduceDays) {
    $reduceAmount = 1500 * $reduceDays;
    $reduceAmountList[] = $reduceAmount;
}
$combine = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
$newReduceAmountList = array_combine($combine, $reduceAmountList);

foreach ($dateAmountList as $date => $object) {
    $renewalDate = date('n', strtotime($date));
    $monthAmountList[$renewalDate] += $object;
}
echo "<br>";
echo "月順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ1500円引いてください。";
echo "<br>";
$output = [];
foreach (array_keys($monthAmountList + $newReduceAmountList) as $key) {
    $output[$key] = ($monthAmountList[$key] - $newReduceAmountList[$key]);
    echo $key . "月の支出の合計" . $output[$key] . "<br>";
}

$sql = "select
            MONTH(accrual_date) as accrual_date
        from
            spendings
        where
            DATE_FORMAT(accrual_date, '%e') in ('5', '15', '25')";
$statement = $pdo->prepare($sql);
$statement->execute();
$results5 = $statement->fetchAll(PDO::FETCH_ASSOC);

$monthCountList = [];
foreach ($results5 as $result5) {
    foreach ($result5 as $key=>$value) {
        $monthCountList[] = $value;
    }
}
$count = array_count_values($monthCountList);
echo "<br>";

$sql = "select
            MONTH(accrual_date) as accrual_time, sum(amount)
        from
            spendings
        group by
            accrual_time
        order by
            sum(amount) desc";
$statement = $pdo->prepare($sql);
$statement->execute();
$results6 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "支出の高い順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ100円引いて下さい。";
echo "<br>";
foreach ($results6 as $result6) {
    foreach ($count as $month=>$days) {
        if ($result6["accrual_time"] == $month) {
            $amountFinal = (int)$result6["sum(amount)"] - 100 * $days;
        }
    }
    echo $result6["accrual_time"] . "月の支出の合計" . $amountFinal . "<br>";
}

$sql = "select
            MONTH(accrual_date) as accrual_time, sum(amount)
        from
            spendings
        group by
            accrual_time
        order by
            sum(amount)";
$statement = $pdo->prepare($sql);
$statement->execute();
$results7 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<br>";
echo "支出の低い順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ3000円引いて下さい。";
echo "<br>";
$monthCountList2 = [];
foreach ($results7 as $result7) {
    foreach ($count as $month => $days) {
        if ($result7["accrual_time"] == $month) {
            $amountAfterReduce2 = (int)$result7["sum(amount)"] -  3000 * $days;
        }
    }
    $monthCountList2[$result7["accrual_time"]] = $amountAfterReduce2;
}
asort($monthCountList2);
foreach ($monthCountList2 as $month2 => $object) {
    echo $month2 . "月の支出の合計" . $object . "<br>";
}
