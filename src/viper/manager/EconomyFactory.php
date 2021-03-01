<?php

declare(strict_types=1);

namespace viper\manager;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use viper\command\commands\AllMoney;
use viper\command\commands\GiveMoney;
use viper\command\commands\MyMoney;
use viper\command\commands\SetMoney;
use viper\ViperEconomy;
use viper\listener\Listener;

class EconomyFactory {

    /** @var EconomyFactory */
    private static $instance;

    /**
     * @return EconomyFactory
     */
    public static function getInstance(): EconomyFactory {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function init(): void {
        @mkdir(ViperEconomy::getInstance()->getDataFolder() . "money");

        Server::getInstance()->getPluginManager()->registerEvents(new Listener(), ViperEconomy::getInstance());

        Server::getInstance()->getCommandMap()->register("mymoney", new MyMoney("mymoney"));
        Server::getInstance()->getCommandMap()->register("setmoney", new SetMoney("setmoney"));
        Server::getInstance()->getCommandMap()->register("givemoney", new GiveMoney("givemoney"));
        Server::getInstance()->getCommandMap()->register("allmoney", new AllMoney("allmoney"));
    }

    /**
     * @param Player $player
     * @return int
     */
    public function getMoney(Player $player): int {
        return (new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML))->get("Balance", 0);
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function setMoney(Player $player, int $amount): void {
        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);

        $data->set("Balance", $amount);
        $data->save();
    }

    /**
     * @param Player $player
     * @param int $amount
     */
    public function giveMoney(Player $player, int $amount): void {
        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);

        $data->set("Balance", $data->get("Balance", 0) + $amount);
        $data->save();
    }

    /**
     * @param int $amount
     */
    public function giveAllMoney(int $amount): void {
        foreach (Server::getInstance()->getOnlinePlayers() as $players) {
            $this->giveMoney($players, $amount);

            $players->sendMessage("Everyone online has received $" . $amount);
        }
    }
}