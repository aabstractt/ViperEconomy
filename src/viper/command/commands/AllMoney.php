<?php

declare(strict_types=1);

namespace viper\command\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use viper\manager\EconomyFactory;

class AllMoney extends Command {

    /**
     * AllMoney constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        parent::__construct($name);

        $this->setUsage("/allmoney");
        $this->setDescription("Give everyone online money!");
        $this->setPermission("viper.allmoney");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender->hasPermission("viper.allmoney")) return;
        if (!$sender instanceof Player) return;

        if (count($args) < 1) {
            $sender->sendMessage("/allmoney [amount]");

            return;
        }

        if (!is_numeric($args[0])) {
            $sender->sendMessage("The amount must be a number!");

            return;
        }
        EconomyFactory::getInstance()->giveAllMoney($args[0]);

        $sender->sendMessage("You have given everyone online $" . $args[0]);
    }
}