<?php

namespace DEN;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerDeathEvent;

use DEN\Main;
use DEN\points;

class Commands{

    /**
     * @param Command $cmd
     * @param CommandSender $sdr
     * @param $label
     * @param array $args
     */
    public function onCmd(Command $cmd, CommandSender $sdr, $label, array $args){

        $cfg = $this->getConfig();

        if(strtolower($cmd->getName()) === "nexus" && isset($args[0]) && isset($args[1])){
            if($args[0] === "setspawn" && $args[1] === "blue" && $sdr->hasPermission("nexus.setspawn")){

                $x = $sdr->getFloorX();
                $y = $sdr->getFloorY();
                $z = $sdr->getFloorZ();

                $cfg->set(array("YellowSpawnX" => $x));
                $cfg->set(array("YellowSpawnY" => $y));
                $cfg->set(array("YellowSpawnZ" => $z));
                $cfg->save();

                $sdr->sendMessage("Blue spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }elseif(!$sdr->hasPermission("nexus.setspawn")){

                $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));

            }

            if($args[0] === "setspawn" && $args[1] === "red") {

                $x = $sdr->getFloorX();
                $y = $sdr->getFloorY();
                $z = $sdr->getFloorZ();

                $cfg->set(array("RedSpawnX" => $x));
                $cfg->set(array("RedSpawnY" => $y));
                $cfg->set(array("RedSpawnZ" => $z));
                $cfg->save();

                $sdr->sendMessage("Red spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }

            if($args[0] === "setspawn" && $args[1] === "green") {

                $x = $sdr->getFloorX();
                $y = $sdr->getFloorY();
                $z = $sdr->getFloorZ();

                $cfg->set(array("GreenSpawnX" => $x));
                $cfg->set(array("GreenSpawnY" => $y));
                $cfg->set(array("GreenSpawnZ" => $z));
                $cfg->save();

                $sdr->sendMessage("Green spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }

            if($args[0] === "setspawn" && $args[1] === "blue") {

                $x = $sdr->getFloorX();
                $y = $sdr->getFloorY();
                $z = $sdr->getFloorZ();

                $cfg->set(array("BlueSpawnX" => $x));
                $cfg->set(array("BlueSpawnY" => $y));
                $cfg->set(array("BlueSpawnZ" => $z));
                $cfg->save();

                $sdr->sendMessage("Blue spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }

            return true;

        }

        if(strtolower($cmd->getName()) === "points"){

            //TODO

        }

    }

}
