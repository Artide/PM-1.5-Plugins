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

class kits{

    public $kits = ["Acrobat","Miner","Swapper","Fighter","Teleporter"];
    public $cost = [400,500,600,750,900];

    /*
     * Acrobat is still not possible to make, might be in future updates.
     */

}
