<?php

declare(strict_types=1);

namespace viper\command\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use viper\manager\EconomyFactory;

class MyMoney extends Command {

    /**
     * MyMoney constructor.
     * @param string $name
     */
    public function __construct(string $name){
        parent::__construct($name, "Check your balance.", "/mymoney", ["/balance", "/mybal", "/bal", "money"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if(!$sender instanceof Player) {
            return;
        }

        $sender->sendMessage("Your balance is: " . intval(EconomyFactory::getInstance()->getMoney($sender)));
    }
}