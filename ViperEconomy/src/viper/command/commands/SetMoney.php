<?php

namespace viper\command\commands;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use viper\manager\Economy;
use viper\ViperEconomy;

class SetMoney extends PluginCommand{
    /**
     * @var
     */
    public $economy;

    /**
     * SetMoney constructor.
     * @param string $name
     * @param ViperEconomy $economy
     */
    public function __construct(string $name, ViperEconomy $economy){
        $this->setUsage("/setmoney");
        $this->setDescription("set players money.");
        $this->setPermission("viper.setmoney");
        parent::__construct($name, $economy);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) return;
        if(!$sender->hasPermission("viper.setmoney")) return;
        if (count($args) < 1) {
            $sender->sendMessage("/setmoney <player> [amount]");
            return false;
        }

        if(!isset($args[0])){
            $sender->sendMessage("You must enter a players name!");
            return false;
        }

        if(!isset($args[1])){
            $sender->sendMessage("You must enter an amount!");
            return false;
        }

        if(!is_numeric($args[1])){
            $sender->sendMessage("The amount must be a number!");
            return false;
        }

        if($args[1] < 0){
            $sender->sendMessage("You cannot give someone a balance less then zero!");
            return false;
        }

        $player = ViperEconomy::getInstance()->getServer()->getPlayer($args[0]);
        if(!$player instanceof Player){
            $sender->sendMessage("That player is not online!");
            return false;
        }
        Economy::setMoney($player, $args[1]);
        $sender->sendMessage("You have set " . $player->getName() . "'s balance to " . $args[1]);
        return parent::execute($sender, $commandLabel, $args);
    }
}