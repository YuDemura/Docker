<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

//spendingsテーブル全７月支出データ取得
$sql = "select
            date_format(accrual_date, '%m%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '07'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

//日付に２が含まれている場合マイナス1000円phpで絞り込み
foreach ($results as $result) {
    $amount = (int)$result["amount"];
    if (strpos($result["date_time"], '2') !== false ) {
        $amount -= 1000;
    } else {
        $amount = $amount;
    }
    $sum += $amount;
}
echo "７月の支出の合計：" . $sum;
echo "<br>";


//spendingsテーブル全8月支出データ取得
$sql = "select
            date_format(accrual_date, '%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '08'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);

//日付に0が含まれている場合マイナス500円phpで絞り込み
foreach ($results2 as $result2) {
    $amount2 = (int)$result2["amount"];
    if (substr($result2["date_time"], -1) == 0) {
        $amount2 -= 500;
    } else {
        $amount2 = $amount2;
    }
    $sum2 += $amount2;
}
echo "8月の支出の合計：" . $sum2;
echo "<br>";


//spendingsテーブル全9月支出データ取得
$sql = "select
            date_format(accrual_date, '%m%d') as date_time, amount
        from
            spendings
        where date_format(accrual_date, '%m') = '09'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results3 = $statement->fetchAll(PDO::FETCH_ASSOC);

//日付に1が含まれている場合マイナス2000円phpで絞り込み
foreach ($results3 as $result3) {
    $amount3 = (int)$result3["amount"];
    if (strpos($result3["date_time"], '1') !== false ) {
        $amount3 -= 2000;
    } else {
        $amount3 = $amount3;
    }
    $sum3 += $amount3;
}
echo "9月の支出の合計：" . $sum3;
echo "<br>";


//月順にsortして月ごとの支出の合計を一覧表示。
$sql = "select
            MONTH(accrual_date) as date_time, sum(amount)
        from
            spendings
        group by
            date_time";
$statement = $pdo->prepare($sql);
$statement->execute();
$results4 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results4);
// var_dump($results4[0]);

//5が含まれている日のみ抽出
$sql = "select
            MONTH(accrual_date) as accrual_date
        from
            spendings
        where
            DATE_FORMAT(accrual_date, '%e') in ('5', '15', '25')";
$statement = $pdo->prepare($sql);
$statement->execute();
$results5 = $statement->fetchAll(PDO::FETCH_ASSOC);
// var_dump($results5);

//①$result5の要素をキー、個数を値とした連想配列を作る
//②月ごとの５のつく日数を取得
$monthCountList = [];
foreach ($results5 as $result5) {
    // var_dump($result5);
    foreach ($result5 as $key=>$value) {
        // var_dump($value);
        $monthCountList[] = $value;
    }
}
// var_dump($monthCountList);
$count = array_count_values($monthCountList);
// var_dump($count);
echo "<br>";
echo "月順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ1500円引いてください。";
echo "<br>";
for ($i = 1; $i < 13; $i++) {
    $afterReducePrice = (int)$results4[$i - 1]["sum(amount)"] - ($count[$i]) * 1500;
    echo " $i "."月の支出の合計" . ($afterReducePrice);
    echo "<br>";
}
echo "<br>";

// 支出の高い順にsortして月ごとの合計を一覧表示。
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
// var_dump($results6);
// var_dump($results6[0]);

echo "支出の高い順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ100円引いて下さい。";
echo "<br>";
foreach ($results6 as $result6) {
    // var_dump($result6);
    foreach ($count as $month=>$days) {
    if ($result6["accrual_time"] == $month) {
        $amountFinal = (int)$result6["sum(amount)"] - 100 * $days;
    }
    }
    // var_dump($amountFinal);
    echo $result6["accrual_time"] . "月の支出の合計" . $amountFinal . "<br>";
}

//支出の低い順にsortして月ごとの支出の合計を一覧表示
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
// var_dump($results7);
// var_dump($results7[0]);

echo "<br>";
echo "支出の低い順にsortして月ごとの支出の合計を一覧表示。ただし、支出日に5が含まれているときだけ3000円引いて下さい。";
echo "<br>";
foreach ($results7 as $result7) {
    // var_dump($result7);
    foreach ($count as $month=>$days) {
    if ($result7["accrual_time"] == $month) {
        $amountFinal2 = (int)$result7["sum(amount)"] -  3000 * $days;
    }
    }
    // var_dump($amountFinal2);
    echo $result7["accrual_time"] . "月の支出の合計" . $amountFinal2 . "<br>";
}
