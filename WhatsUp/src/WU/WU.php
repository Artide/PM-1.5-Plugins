<?php

namespace WU;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TXT;

class WU extends PluginBase{

    public function onEnable()
    {
        $log = $this->getLogger();
        $log->info(TXT::GREEN . "Plugin enabled!");
        $this->saveDefaultConfig();
        $this->reloadConfig();
    }

    public function WhatsUp($player, $message)
    {
        $format = $this->getConfig()->get("Format");
        return $player->setNameTag(str_replace(["@player", "@whats_up"], [$player->getName(), $message], $format));
    }

    public function onCommand(CommandSender $p, Command $c, $label, array $args)
    {
        switch(strtolower($c->getName())){
            //case 'whatsup':
            case 'wu':
                if($p->hasPermission("wu.wu")){
                    foreach($args as $status){
                        self::WhatsUp($p, $status);
                        $p->sendMessage(TXT::GREEN . "Status set to '" . $status . "'.");
                        return;
                    }
                    if(count($args) < 1){
                        $p->sendMessage(TXT::RED . "Failed to set status. Usage: /wu <status>");
                    }else{
                        return;
                    }
                    if(!$p instanceof Player){
                        $p->sendMessage(TXT::RED . "Please run this command in-game.");;
                    }else{
                        return;
                    }
                }
            break;
        }
    }
}
