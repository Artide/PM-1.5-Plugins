<?php

namespace DEN\Task;

use <?php

namespace DEN\Task;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerDeathEvent;

use DEN\Main;
use DEN\Timer;
use DEN\Commands;

class Teams{

    public function __construct(Teams $plugin){

        $this->plug = $plugin;

    }

    /**
     * @param $p
     */
    public function yellow($p){

        $p->getInventory()->setHelmet(Item::get(298));
        $p->getInventory()->setChesplate(Item::get(299));
        $p->getInventory()->setLeggings(Item::get(300));
        $p->getInventory()->setBoots(Item::get(301));
        $p->setNameTag(TXT::YELLOW . $p->getName());
        
        return self::yellow($p);

    }

    /**
     * @param $p
     */
    public function red($p){

        $p->getInventory()->setHelmet(Item::get(298));
        $p->getInventory()->setChesplate(Item::get(299));
        $p->getInventory()->setLeggings(Item::get(300));
        $p->getInventory()->setBoots(Item::get(301));
        $p->setNameTag(TXT::RED . $p->getName());

        return self::red($p);

    }

    /**
     * @param $p
     */
    public function green($p){

        $p->getInventory()->setHelmet(Item::get(298));
        $p->getInventory()->setChesplate(Item::get(299));
        $p->getInventory()->setLeggings(Item::get(300));
        $p->getInventory()->setBoots(Item::get(301));
        $p->setNameTag(TXT::GREEN . $p->getName());

        return self::green($p);

    }

    /**
     * @param $p
     */
    public function blue($p){

        $p->getInventory()->setHelmet(Item::get(298));
        $p->getInventory()->setChesplate(Item::get(299));
        $p->getInventory()->setLeggings(Item::get(300));
        $p->getInventory()->setBoots(Item::get(301));
        $p->setNameTag(TXT::BLUE . $p->getName());

        return self::blue($p);

    }

    /**
     * @param EntityDamageEvent $e
     */

    public function onDamage(EntityDamageEvent $e, $msg){

        $target = $e->getEntity();
        $damager = $target->getLastDamageCause()->getCause();

        if($target instanceof Player && $damager instanceof Player){

            if($this->yellow($target) && $this->yellow($damager)) {

                $e->setCancelled();
                $damager->sendMessage(Main::pfx . $this->getConfig()->get("FriendlyAttackMessage"));

                return true;

            }elseif($this->red($target) && $this->red($damager)){

                $e->setCancelled();
                $damager->sendMessage(Main::pfx . $this->getConfig()->get("FriendlyAttackMessage"));

                return true;

            }elseif($this->green($target) && $this->green($damager)){

                $e->setCancelled();
                $damager->sendMessage(Main::pfx . $this->getConfig()->get("FriendlyAttackMessage"));

                return true;

            }elseif($this->blue($target) && $this->blue($damager)){

                $e->setCancelled();
                $damager->sendMessage(Main::pfx . $this->getConfig()->get("FriendlyAttackMessage"));

                return true;

            }else{

                return false;

            }

        }

        $msg = $this->getConfig()->get("FriendlyAttackMessage");
        $msg = str_replace("{FRIEND}", $target->getName(), $msg);

        return $msg;

    }

    /**
     * @param PlayerDeathEvent $e
     */
    public function onDeath(PlayerDeathEvent $e){

        $p = $e->getPlayer();
        $cfg = $this->getConfig();
        
        $yellowspawn = [$cfg->get("YellowSpawnX"),$cfg->get("YellowSpawnY"),$cfg->get("YellowSpawnZ")];
        $redspawn = [$cfg->get("RedSpawnX"),$cfg->get("RedSpawnY"),$cfg->get("RedSpawnZ")];
        $greenspawn = [$cfg->get("GreenSpawnX"),$cfg->get("GreenSpawnY"),$cfg->get("GreenSpawnZ")];
        $bluespawn = [$cfg->get("BlueSpawnX"),$cfg->get("BlueSpawnY"),$cfg->get("BlueSpawnZ")];
        
        if($this->yellow($p)){

            $p->teleport(new Position($yellowspawn));
            
        }
        
        if($this->red($p)){
            
            $p->teleport(new Postition($redspawn));
            
        }
        
        if($this->green($p)){
            
            $p->teleport(new Postition($greenspawn));
            
        }
        
        if($this->blue($p)){
            
            $p->teleport(new Postitio($bluespawn));
            
        }
        
    }

    /**
     * @param $p
     * @return string
     */
    public function getTeam(Player $p){
        
        $yellow = [$p->getName(), " : Yellow"];
        $red = [$p->getName, " : Red"];
        $green = [$p->getName, " : Green"];
        $blue = [$p->getName, " : Blue"];
        
        if($this->yellow($p)){

            return $yellow;

        }elseif($this->red($p)){
            
            return $red;

        }elseif($this->green($p)){
            
            return $green;

        }elseif($this->blue($p)){

            return $blue;

        }else{

            return Main::error . " no team set for " . $p->getName();

        }

    }


    /**
     * @param $p
     * @param $team
     */

    public function setTeam($p, $team){

        //TODO

    }

}

