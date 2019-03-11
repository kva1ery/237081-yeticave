<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, <?=esc($winner["winner_name"]);?></p>
<p>Ваша ставка для лота <a href="http://<?=$_SERVER["HTTP_HOST"];?>/lot.php?id=<?=$winner["id"];?>"><?=esc($winner["name"]);?></a> победила.</p>
<p>Перейдите по ссылке <a href="http://<?=$_SERVER["HTTP_HOST"];?>/mylots.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>
</body>
</html>
