<?php

namespace viper\command\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use viper\manager\Economy;
use viper\ViperEconomy;

class MyMoney extends PluginCommand{
    /**
     * @var
     */
    public $economy;

    /**
     * MyMoney constructor.
     * @param string $name
     * @param ViperEconomy $economy
     */
    public function __construct(string $name, ViperEconomy $economy){
        $this->setUsage("/mymoney");
        $this->setDescription("Check your balance.");
        $this->setAliases(["/balance", "/mybal", "/bal", "money"]);
        parent::__construct($name, $economy);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return;
        $balance = Economy::getMoney($sender);
        $sender->sendMessage("Your balance is: " . intval($balance));
        return parent::execute($sender, $commandLabel, $args);
    }
}