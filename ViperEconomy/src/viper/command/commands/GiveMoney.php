<?php

namespace viper\command\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use viper\manager\Economy;
use viper\ViperEconomy;

use pocketmine\command\PluginCommand;

class GiveMoney extends PluginCommand{
    /**
     * @var
     */
    public $economy;

    /**
     * GiveMoney constructor.
     * @param string $name
     * @param ViperEconomy $economy
     */
    public function __construct(string $name, ViperEconomy $economy){
        $this->setUsage("/givemoney <player> [amount]");
        $this->setDescription("Give money to players!");
        $this->setPermission("viper.givemoney");
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
        if(!$sender->hasPermission("viper.givemoney")) return;

        if(count($args) < 1){
            $sender->sendMessage("/givemoney <player> [amount]");
            return false;
        }

        if(!isset($args[0])){
            $sender->sendMessage("You must supply a player!");
            return false;
        }

        if(!isset($args[1])){
            $sender->sendMessage("You must supply an amount!");
            return false;
        }

        if(!is_numeric($args[1])){
            $sender->sendMessage("The amount needs to be a number!");
            return false;
        }

        if($args[1] < 0){
            $sender->sendMessage("The amount needs to be more then zero!");
            return false;
        }

        $player = ViperEconomy::getInstance()->getServer()->getPlayer($args[0]);
        if(!$player instanceof Player){
            $sender->sendMessage("That player is not online!");
            return false;
        }
        Economy::giveMoney($player, $args[1]);
        $sender->sendMessage("You have given " . $player->getName() . " $" . $args[1]);
        return parent::execute($sender, $commandLabel, $args);
    }
}