<?php

namespace viper\command\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use viper\manager\Economy;
use viper\ViperEconomy;

class AllMoney extends PluginCommand{
    /**
     * @var
     */
    public $economy;

    /**
     * AllMoney constructor.
     * @param string $name
     * @param ViperEconomy $economy
     */
    public function __construct(string $name, ViperEconomy $economy){
        $this->setUsage("/allmoney");
        $this->setDescription("Give everyone online money!");
        $this->setPermission("viper.allmoney");
        parent::__construct($name, $economy);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender->hasPermission("viper.allmoney")) return;
        if(!$sender instanceof Player) return;

        if(count($args) < 1){
            $sender->sendMessage("/allmoney [amount]");
            return false;
        }

        if(!is_numeric($args[0])){
            $sender->sendMessage("The amount must be a number!");
            return false;
        }
        Economy::giveAllMoney($args[0]);
        $sender->sendMessage("You have given everyone online $" . $args[0]);
        return parent::execute($sender, $commandLabel, $args);
    }
}