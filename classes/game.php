<?php

class Game {
    public $player1;
    public $player2;
    public $flips = 1; // Количество подбрасываний монеты

    public $gameOver = false;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }
 // Подбрасывает монету и возвращает результат ("Орёл" или "Решка")
    public function flip()
    {
        return rand(0, 1) ? "Орёл" : "Решка";
    }
// Начинает игру, выводит шансы каждого игрока и запускает процесс игры
    public function start()
    {/*
        echo <<<EOT
            {$this->player1->name} шанс: {$this->player1->odds($this->player2)}
            {$this->player2->name} шанс: {$this->player2->odds($this->player1)}
        EOT;*/
        $_SESSION['game'] = $this;
        $this->play();
    }
// Запускает процесс игры
    public function play()
    {
        while(true) {

            if($this->flip() == "Орёл") {
                $this->player1->point($this->player2);
            } else {
                $this->player2->point($this->player1);
            }

            if($this->player1->bankruptcy() || $this->player2->bankruptcy()) {
                $this->gameOver = true;
                return $this->end();
            }

            $this->flips ++;
        }

    }
// Определяет победителя на основе банков игроков
    public function winner(): Player
    {
        return $this->player1->bank() > $this->player2->bank() ? $this->player1 : $this->player2;
    }
// Завершает игру и выводит информацию о результатах
    public function end()
    {
        /*echo <<<EOT

            Конец игры:

            Количество монет:
            {$this->player1->name}: {$this->player1->coins}
            {$this->player2->name}: {$this->player2->coins}

            Победитель: {$this->winner()->name}

            Количество подбрасываний: $this->flips

        EOT;*/
    }
}
