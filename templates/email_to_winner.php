<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1><?=$winner["winner_name"];?> вы выиграли аукцион на сайте YetiCave</h1>

<p>Ваша ставка в <i><?=currency_format($winner["price"]);?></i> рублей сыграла в аукционе на покупку &laquo;<?=$winner["name"];?>&raquo;</p>

</body>
</html>