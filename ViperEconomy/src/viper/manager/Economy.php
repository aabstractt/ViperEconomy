<?php

namespace viper\manager;

use pocketmine\Player;
use pocketmine\utils\Config;
use viper\command\CommandManager;
use viper\ViperEconomy;
use viper\listener\Listener;

class Economy{

    public static function Enable(): void{
        @mkdir(ViperEconomy::getInstance()->getDataFolder() . "money");
        new Listener(ViperEconomy::getInstance());
        CommandManager::Commands();
    }

    /**
     * @param Player $player
     * @return int
     */
    public static function getMoney(Player $player): int{
        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $balance = $data->get("Balance");
        return $balance;
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public static function setMoney(Player $player, int $amount): void{
        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $data->set("Balance", $amount);
        $data->save();
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public static function giveMoney(Player $player, int $amount): void{
        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $data->set("Balance", $data->get("Balance") + $amount);
        $data->save();
    }

    /**
     * @param int $amount
     */
    public static function giveAllMoney(int $amount): void{
        $online = ViperEconomy::getInstance()->getServer()->getOnlinePlayers();
        foreach($online as $players){
            $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($players->getName()) . ".yml", Config::YAML);
            $data->set("Balance", $data->get("Balance") + $amount);
            $data->save();
            $players->sendMessage("Everyone online has received $" . $amount);
        }
    }
}