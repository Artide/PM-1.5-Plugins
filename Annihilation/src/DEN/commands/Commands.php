<?php

namespace DEN\Commands;

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

    public function __construct(points $plugin){

        $this->plug = $plugin;

    }

    public function val(Player $p,$msg){

        $msg = $this->getConfig()->getAll();
        $msg = str_replace("{NAME}",$p->getName(),$msg);

    }

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

                $sdr->sendMessage(Main::pfx . " Blue spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }elseif(!$sdr->hasPermission("nexus.setspawn")){

                $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));
                return true;

            }

            if($args[0] === "setspawn" && $args[1] === "red") {

                $x = $sdr->getFloorX();
                $y = $sdr->getFloorY();
                $z = $sdr->getFloorZ();

                $cfg->set(array("RedSpawnX" => $x));
                $cfg->set(array("RedSpawnY" => $y));
                $cfg->set(array("RedSpawnZ" => $z));
                $cfg->save();

                $sdr->sendMessage(Main::pfx . " Red spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }elseif(!$sdr->hasPermission("nexus.setspawn")){

                $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));
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

                $sdr->sendMessage(Main::pfx . " Green spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }elseif(!$sdr->hasPermission("nexus.setspawn")){

                $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));
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

                $sdr->sendMessage(Main::pfx . " Blue spawn set to " . $x . ", " . $y . ", " . $z);
                return true;

            }elseif(!$sdr->hasPermission("nexus.setspawn")){

                $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));
                return true;

            }

        }

        if(strtolower($cmd->getName()) === "points"){

            $points = $this->plug->getPoints($sdr);

                $sdr->sendMessage(Main::pfx . " Points: " . $points);
                return true;

        }

        if(strtolower($cmd->getName()) === "points" && isset($args[0])){

            $player = $this->getServer()->getPlayerExact($args[0]);

            $points = $this->plug->getPoints($player);

            $sdr->sendMessage(Main::pfx . " Points: " . $points);
            return true;

        }

        if(strtolower($cmd->getName()) === "setpoints" && isset($args[0]) && isset($args[1]) && $sdr->hasPermission("nexus.setpoints")){

            $points = $args[0];
            $player = $this->getServer()->getPlayerExact($args[1]);

            $this->plug->setPoints($points, $player);
            $sdr->sendMessage(Main::pfx . " set " . $player . "'s poins to: " . $points);

            if($player === null){

                $sdr->sendMessage(Main::pfx . " " . $player . " not is not online.");
                return true;

            }

        }elseif(!$sdr->hasPermission("nexus.setpoints")){

            $sdr->sendMessage(Main::error . $cfg->get("NoPermission"));
            return true;

        }

    }

}
