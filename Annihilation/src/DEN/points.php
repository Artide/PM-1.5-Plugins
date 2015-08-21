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
use pocketmine\event\entity\EntityDamageEvent;

class points
{

    public function __construct(points $plugin)
    {

        $this->plug = $plugin;

    }

    public function onDeath(EntityDamageEvent $e, $msg, $pts){

        $victim = $e->getEntitiy();
        if ($victim instanceof Player) {

            $victim->sendMessage($this->getConfig()->get("PlayerDeathMessage");

            }

        $damager = $victim->getLastDamageCause()->getCause();

        if ($damager = 1) {

            $attacker = $victim->getLastDamageCause()->getCause();

            if ($attacker instanceof Player) {

                $apoints = new Config($this->getDataFolder() . "points/" . strtolower($victim->getName()) . ".yml", Config::YAML));
                if ($apoints->exists("Points")) {

                    $apoints->set($apoints->get("Points") + $this->getConfig()->get("GainedPoints"));
                    $apoints->save();
                    $attacker->sendMessage(Main::pfx . $this->getConfig()->get("GainedPointsMessage"));
                    return true;

                } else {

                    $apoints->set(array($apoints->get("Points") => $this->getConfig()->get("GainedPoints")));
                    $apoints->save();
                    $attacker->sendMessage(Main::pfx . $this->getConfig()->get("GainedPointsMessage"));
                    return true;

                }

            }

        }

        $msg = $this->getConfig()->getAll();
        $msg = str_replace("{VICTIM}",$victim->getName(),$msg);
        $msg = str_replace("{ATTACKER}", $attacker->getName(), $msg);

        return $msg;

        $pts = $this->getConfig()->getAll();
        $pts = str_replace("{POINTS}", $apoints->get("Points"),$pts);
        $pts = str_replace("{GAINED}", $this->getConfig()->get("GainedPoints"),$pts);

        return $pts;

    }

}
