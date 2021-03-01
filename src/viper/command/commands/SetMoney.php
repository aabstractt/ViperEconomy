<?php

declare(strict_types=1);

namespace viper\command\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use viper\manager\EconomyFactory;

class SetMoney extends Command {

    /**
     * SetMoney constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        parent::__construct($name);
        $this->setUsage("/setmoney");
        $this->setDescription("set players money.");
        $this->setPermission("viper.setmoney");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player || !$sender->hasPermission("viper.setmoney")) return;

        if (count($args) < 1) {
            $sender->sendMessage("/setmoney <player> [amount]");

            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage("You must enter a players name!");

            return;
        }

        if (!isset($args[1])) {
            $sender->sendMessage("You must enter an amount!");

            return;
        }

        if (!is_numeric($args[1])) {
            $sender->sendMessage("The amount must be a number!");

            return;
        }

        if ($args[1] < 0) {
            $sender->sendMessage("You cannot give someone a balance less then zero!");

            return;
        }

        $player = Server::getInstance()->getPlayer($args[0]);

        if (!$player instanceof Player) {
            $sender->sendMessage("That player is not online!");

            return;
        }

        EconomyFactory::getInstance()->setMoney($player, $args[1]);

        $sender->sendMessage("You have set " . $player->getName() . "'s balance to " . $args[1]);
    }
}