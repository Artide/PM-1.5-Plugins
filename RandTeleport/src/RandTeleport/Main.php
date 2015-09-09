<?php

namespace RandTeleport;

use pocketmine\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;

class Main extends PluginBase{

    public function onEnable(){

        $log = $this->getLogger();

        $log->info("Plugin successfully loaded!");

    }

    /**
     * @param $p
     * @return mixed
     */
    public function rand_tp($p){

        return $p->teleport($p->getLevel()->getSafeSpawn(new Vector3(rand(0,255), rand(0,127), rand(0,255))));

    }

    /**
     * @param CommandSender $sender
     * @param Command $cmd
     * @param $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){

        switch(strtolower($cmd->getName())){

            case 'rand':

                if($sender->hasPermission("randtp.rand")){

                    if($sender instanceof Player){

                        $this->rand_tp($sender);

                        $sender->sendMessage(TXT::GREEN . "Teleporting...");

                    }else{

                        $sender->sendMessage(TXT::RED . "Please run this command in game.");

                        return true;

                    }

                }
            break;

        }

    }

}
