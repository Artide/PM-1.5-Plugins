<?php
<?php

namespace DEN;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\item\item;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;

class kits{

    public $kits = ["Acrobat","Miner","Swapper","Fighter","Teleporter"];
    public $cost = [400,500,600,750,900];

    /*
     * Acrobat is still not possible to make, might be in future updates.
     */

    public function kits(BlockBreakEvent $bbe, EntityDamageEvent $ede){

        $block = $bbe->getBlock();
        $player = $bbe->getPlayer();

        foreach($this->kits[0] as $kit => $value){

            switch($kit){

                case "Miner":

                    //TODO

                    break;

                case "Swapper":

                    //TODO

                    break;

                case "Fighter":

                    //TODO

                    break;

                case "Teleporter":

                    //TODO

                    break;

            }

        }

    }

}
