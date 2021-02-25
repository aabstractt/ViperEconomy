<?php

namespace viper\listener;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use viper\ViperEconomy;

class Listener implements \pocketmine\event\Listener {

    /**
     * @var
     */
    public $economy;

    /**
     * Listener constructor.
     * @param ViperEconomy $economy
     */
    public function __construct(ViperEconomy $economy){
        $this->economy = $economy;
        ViperEconomy::getInstance()->getServer()->getPluginManager()->registerEvents($this, $economy);
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function getData(PlayerJoinEvent $event): void{
        $player = $event->getPlayer();
        $name = $player->getName();

        $data = new Config(ViperEconomy::getInstance()->getDataFolder() . "money/" . strtolower($name) . ".yml", Config::YAML);

        if($data->get("Name") == null){
            $data->set("Name", $name);
            $data->save();
        }

        if($data->get("Balance") == null){
            $data->set("Balance", 1000);
            $data->save();
        }
    }

}