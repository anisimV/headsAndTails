<?php

class Player {
    public $name; // Имя игрока
    public $coins; // Количество монет у игрока

    public function __construct($name, $coins)
    {
        $this->name = $name;
        $this->coins = $coins;
    }
// Увеличивает количество монет текущего игрока на 1 и уменьшает количество монет соперника на 1
    public function point(Player $player)
    {
        $this->coins++;
        $player->coins--;
    }
// Проверяет, находится ли игрок в банкротстве (имеет ли 0 монет)
    public function bankruptcy()
    {
        return $this->coins == 0;
    }
// Возвращает текущее количество монет у игрока
    public function bank()
    {
        return $this->coins;
    }
// Рассчитывает шансы текущего игрока на основе его банка и банка соперника
    public function odds(Player $player)
    {
        return round($this->bank() / ($this->bank() + $player->bank()), 2) * 100 . '%';
    }
}
