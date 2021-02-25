<?php

namespace viper;

use pocketmine\plugin\PluginBase;

use viper\manager\Economy;

class ViperEconomy extends PluginBase{

    /**
     * @var
     */
    private static $instance;


    public function onLoad(){
        self::$instance = $this;
        $this->getLogger()->alert("Loaded.");
    }

    public function onEnable(){
        $this->Enable();
        $this->getLogger()->alert("Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->warning("Disabled.");
    }

    public function Enable(): void{
        Economy::Enable();
    }

    /**
     * @return static
     */
    public static function getInstance(): self{
        return self::$instance;
    }

}