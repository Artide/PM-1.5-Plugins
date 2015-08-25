<?php

namespace DEN;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\event\entity\EntityDamageEvent;

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

        return $this->yellow($p);

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

        return $this->red($p);

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

        return $this->green($p);

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

        return $this->blue($p);

    }

    /**
     * @param EntityDamageEvent $e
     */

    public function onDamage(EntityDamageEvent $e, $msg){

        $target = $e->getEntity();
        $damager = $target->getLastDamageCause()->getCause();

        if($target instanceof Player && $damager instanceof Player){

            if($this->yellow($target) && $this->yellow($damager)){

                $e->setCancelled();

            }else{

                $damager->sendMessage(Main::pfx . $this->getConfig()->get("FriendlyAttackMessage"));

            }

        }

        $msg = $this->getConfig()->get("FriendlyAttackMessage");
        $msg = str_replace("{FRIEND}", $target->getName(), $msg);

        return $msg;

    }

    /**
     * @param $p
     * @return string
     */
    public function getTeam($p){

        if($this->yellow($p)){

            return "Yellow";

        }elseif($this->red($p)){

            return "Red";

        }elseif($this->green($p)){

            return "Green";

        }elseif($this->blue($p)){

            return "Blue";

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
