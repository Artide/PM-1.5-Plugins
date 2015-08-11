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

class Timer{

    /**
     * @param Main $plugin
     */
    public function __construct(Main $plugin){

        $this->plug = $plugin;

    }

    private $pool = [];

    /**
     * @param $tick
     */
    public function onRun($currentTick){

        $this->hasMatchStarted = $this->plug->stime[0];


        $this->plug->stime -= 1;
        $this->plug->fasetimerone -=1;
        $this->plug->fasetimertwo -=1;
        $this->plug->fasetimerthree -=1;
        $this->plug->fasetimerfour -=1;

        $players = $this->getServer()->getLevelByName($this->getConfig()->get(array("lobby-list"))->getPlayers());

        foreach($players as $p){

            $p->sendTip(Main::pfx . " Match starting in " . $this->plug->stime . " second(s)");

        }

        $fplayers = $this->getServer()->getLevelByName($this->getConfig()->get(array("arena-list"))->getPlayers());

        foreach($fplayers as $p){

            $p->sendTip("Phase I: " . $this->plug->fasetimerone);

            if($this->plug->fasetimerone === 0){

                $p->sendTip("Phase II: " . $this->plug->fasetimertwo);

                $p->sendMessage(Mian::pfx . " Phase II. All nexus have lost invincibility");

                return true;

            }

            if($this->plug->fasetimertwo === 0){

                $p->sendTip("Phase III: " . $this->plug->fasetimerthree);

                $p->sendMessage(Main::pfx . " Phase III. Diamonds appear in the middle.");

                return true;

            }

            if($this->plug->fasetimerthree === 0){

                $p->sendTip("Phase IV: " . $this->plug->fasetimerfour);

                $p->sendMessage(Main::pfx . " Phase IV. Blaze powder is available in shop.");

                return true;

            }

            if($this->plug->fasetimerfour === 0){

                $p->sendTip("Phase V");

                $p->sendMessage(Main::pfx . " Phase V. All nexus now take extra damage.");

                return true;

            }

        }

        while(($block = $this->next($currentTick) !== null)){
            if($block->isValid()){
                $block->getLevel()->setBlock($block, $block);

            }

        }

    }

    public function onCancel(){

        foreach($this->pool as $string){
            $block = $this->unhashString($string);

            if($block->isValid()){
                $block->getLevel()->setBlock($block, $block);
            }

        }

    }

    public function push(Block $block){

        $restoreTick = $this->getOwner()->getServer()->getTick() + 600;
        $this->pool[] = "$restoreTick:$block->x:$block->y:$block->z:{$block->getId()}:{$block->getDamage()}:{$block->getLevel()->getName()}"; // we do not want to hold the instances, especially those holding a Level instance, because it will cause server issues if the level is unloaded

    }

    public function next($currentTick){

        $nextTick = (int) strstr($this->pool[0], ":", true);

        if($nextTick <= $currentTick){
            return $this->unhashBlock(array_shift($this->pool));

        }

        return null;

    }

    private function unhashBlock($string){

        list(, $x, $y, $z, $id, $damage, $lvName) = explode(":", $string);
        return Block::get($id, $damage, new Position($x, $y, $z, $this->getOwner()->getServer()->getLevelByName($lvName)));

    }

}
