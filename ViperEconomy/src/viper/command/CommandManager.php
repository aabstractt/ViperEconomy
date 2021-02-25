<?php

namespace viper\command;

use viper\ViperEconomy;

use viper\command\commands\{
    MyMoney,
    SetMoney,
    GiveMoney,
    AllMoney
};


class CommandManager{

    public static function Commands(): void{
        ViperEconomy::getInstance()->getServer()->getCommandMap()->register("mymoney", new MyMoney("mymoney", ViperEconomy::getInstance()));
        ViperEconomy::getInstance()->getServer()->getCommandMap()->register("setmoney", new SetMoney("setmoney", ViperEconomy::getInstance()));
        ViperEconomy::getInstance()->getServer()->getCommandMap()->register("givemoney", new GiveMoney("givemoney", ViperEconomy::getInstance()));
        ViperEconomy::getInstance()->getServer()->getCommandMap()->register("allmoney", new AllMoney("allmoney", ViperEconomy::getInstance()));
    }

}