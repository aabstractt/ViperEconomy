<?php

declare(strict_types=1);

namespace viper\command\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use viper\manager\EconomyFactory;

class GiveMoney extends Command {

    /**
     * GiveMoney constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        parent::__construct($name);
        $this->setUsage("/givemoney <player> [amount]");
        $this->setDescription("Give money to players!");
        $this->setPermission("viper.givemoney");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) return;
        if (!$sender->hasPermission("viper.givemoney")) return;

        if (count($args) < 1) {
            $sender->sendMessage("/givemoney <player> [amount]");

            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage("You must supply a player!");

            return;
        }

        if (!isset($args[1])) {
            $sender->sendMessage("You must supply an amount!");

            return;
        }

        if (!is_numeric($args[1])) {
            $sender->sendMessage("The amount needs to be a number!");

            return;
        }

        if ($args[1] < 0) {
            $sender->sendMessage("The amount needs to be more then zero!");

            return;
        }

        $player = Server::getInstance()->getPlayer($args[0]);

        if (!$player instanceof Player) {
            $sender->sendMessage("That player is not online!");

            return;
        }

        EconomyFactory::getInstance()->giveMoney($player, $args[1]);

        $sender->sendMessage("You have given " . $player->getName() . " $" . $args[1]);
    }
}