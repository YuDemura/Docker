<?php
$dbUserName = "root";
$dbPassword = "password";
$pdo = new PDO("mysql:host=mysql; dbname=tq_quest; charset=utf8", $dbUserName, $dbPassword);

$sql = "select * from categories";
$statement = $pdo->prepare($sql);
$statement->execute();
$results2 = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "「" . $results2[2]["name"] . "」" . "カテゴリーの支出を一覧表示してみてください。<br>";

$sql = "select
            accrual_date, name, amount
        from
            spendings
        where
            name = 'ネット' or name = '携帯'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    echo $result["accrual_date"] . "に支払った" . $result["name"] . "料金: " . $result["amount"] . "<br>";
}

echo "<br>「" . $results2[1]["name"] . "」" . "カテゴリーの支出を一覧表示してみてください。<br>";

$sql = "select
            accrual_date, name, amount
        from
            spendings
        where
            name = '水道代' or name = '電気代'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results3 = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($results3 as $result3) {
    echo $result3["accrual_date"] . "に支払った" . $result3["name"] . "料金: " . $result3["amount"] . "<br>";
}

echo "<br>「" . $results2[0]["name"] . "」" . "カテゴリーの支出を一覧表示してみてください。<br>";

$sql = "select
            accrual_date, name, amount
        from
            spendings
        where
            name = '家賃' or name = '駐車場代'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results4 = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($results4 as $result4) {
    echo $result4["accrual_date"] . "に支払った" . $result4["name"] . "料金: " . $result4["amount"] . "<br>";
}

echo "<br>「" . $results2[3]["name"] . "」" . "カテゴリーの支出を一覧表示してみてください。<br>";

$sql = "select
            accrual_date, name, amount
        from
            spendings
        where
            name = '飲み会' or name = '誕生日会' or name = 'TDL' or name = 'デート' or name = 'お花見' or name = 'キャンプ' or  name = 'BBQ' or name = '忘年会'";
$statement = $pdo->prepare($sql);
$statement->execute();
$results5 = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($results5 as $result5) {
    echo $result5["accrual_date"] . "に支払った" . $result5["name"] . "料金: " . $result5["amount"] . "<br>";
}
