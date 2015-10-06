<?php

namespace WU;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\command\ConsoleCommandSender;

class WU extends PluginBase{

    public function onEnable()
    {
        $log = $this->getLogger();
        $log->info(TXT::GREEN . "Plugin enabled!");
        $this->saveDefaultConfig();
        $this->reloadConfig();
    }

    /**
     * @param $player
     * @param $message
     * @return mixed
     */
    public function WhatsUp($player, $message)
    {
        $format = $this->getConfig()->get("Format");
        return $player->setNameTag(str_replace(["@player", "@whats_up"], [$player->getName(), $message], $format));
    }

    /**
     * @param CommandSender $p
     * @param Command $c
     * @param $label
     * @param array $args
     */
    public function onCommand(CommandSender $p, Command $c, $label, array $args)
    {
        switch(strtolower($c->getName())){
            //case 'whatsup':
            case 'wu':
                if($p->hasPermission("wu.wu")){
                    if($p instanceof Player) {
                        self::WhatsUp($p, implode(" ", $args));
                        $p->sendMessage(TXT::GREEN . "Status set to '" . implode(" ", $args) . "'.");
                    }else{
                        $p->sendMessage(TXT::RED . "Please run this command in-game.");
                    }
                    if(empty($args) && count($args) === 0){
                        $p->sendMessage(TXT::RED . "Failed to set status. Usage: /wu <status>");
                    }else{
                        return;
                    }
                    return;
                }
            break;
        }
    }
}
