<?php

namespace viper;

use pocketmine\plugin\PluginBase;

use viper\manager\EconomyFactory;

class ViperEconomy extends PluginBase {

    /** @var ViperEconomy */
    private static $instance;

    public function onLoad(): void {
        self::$instance = $this;

        $this->getLogger()->alert("Loaded.");
    }

    public function onEnable(): void {
        EconomyFactory::getInstance()->init();

        $this->getLogger()->alert("Enabled.");
    }

    public function onDisable(): void {
        $this->getLogger()->warning("Disabled.");
    }

    /**
     * @return ViperEconomy
     */
    public static function getInstance(): self {
        return self::$instance;
    }
}