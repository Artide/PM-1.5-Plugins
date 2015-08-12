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
use pocketmine\event\entity\EntityDamageByEntityEvent;

class points{

    public $points = 0;

    public function __construct(points $plugin){

        $this->plug = $plugin;

    }

    public function onDeath(PlayerDeathEvent $e){

        $victim = $e->getEntitiy();
        if($victim instanceof Player){
            $points = new Config($this->getDataFolder() . "points/" . strtolower($victim->getName() . ".yml", Config::YAML));

            //TODO
            
        }

    }

}
