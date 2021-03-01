<?php

declare(strict_types=1);

namespace viper\listener;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use viper\ViperEconomy;

class Listener implements \pocketmine\event\Listener {

    /**
     * @param PlayerJoinEvent $ev
     *
     * @priority NORMAL
     */
    public function onPlayerJoinEvent(PlayerJoinEvent $ev): void{
        $player = $ev->getPlayer();

        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($player->getName()) . ".yml", Config::YAML);

        if(!$data->exists('Name')){
            $data->set("Name", $player->getName());
        }

        if(!$data->exists("Balance")){
            $data->set("Balance", 1000);
        }

        $data->save();
    }

}