<?php

session_start();

require_once 'classes/game.php';
require_once 'classes/player.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['start_game'])) {
        $player1 = new Player("Anton", 100);
        $player2 = new Player("Anisim", 100);
        $game = new Game($player1, $player2);
        $_SESSION['game'] = $game;
        $game->start();
    } elseif (isset($_POST['end_game'])) {
        unset($_SESSION['game']);
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

if (isset($_SESSION['game'])) {
    $game = $_SESSION['game'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Орел и Решка</title>
</head>
<body>
    <div>
        <h2>Игровой интерфейс</h2>
    </div>

    <?php if (isset($game) && !$game->player1->bankruptcy() && !$game->player2->bankruptcy()) : ?>
        
        <div class="result">
            <?php echo $game->player1->name; ?> шанс: <?php echo $game->player1->odds($game->player2); ?><br>
            <?php echo $game->player2->name; ?> шанс: <?php echo $game->player2->odds($game->player1); ?>
        </div>

    <?php endif; ?>

    <?php if (!isset($_SESSION['game']) || (isset($game) && ($game->player1->bankruptcy() || $game->player2->bankruptcy()))) : ?>

        <div>
            <form method="post">
                <input type="submit" name="start_game" value="Играть">
            </form>
        </div>

    <?php endif; ?>

    <?php if (isset($game) && ($game->player1->bankruptcy() || $game->player2->bankruptcy())) : ?>

        <div class="result">
            Конец игры:<br><br>
            Количество монет:<br>
            <?php echo $game->player1->name; ?>: <?php echo $game->player1->coins; ?><br>
            <?php echo $game->player2->name; ?>: <?php echo $game->player2->coins; ?><br><br>
            Победитель: <?php echo $game->winner()->name; ?><br><br>
            Количество подбрасываний: <?php echo $game->flips; ?>
        </div>

        <div>
            <form method="post">
                <input type="submit" name="end_game" value="Завершить игру">
            </form>
        </div>

    <?php endif; ?>

</body>
</html>
