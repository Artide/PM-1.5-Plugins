<?php

/*
 *@Copyright 2015
 *
 *@Artide
 *
 * I give you permission to edit this content.
 * Do not distribute!
 *
 */

namespace Sneaked;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerItemHeldEvent;

class Main extends PluginBase implements Listener{

    public function onLoad(){

        $this->getLogger()->info("Loading...");

    }

    public function onEnable(){

        $this->saveDefaultConfig();
        $this->reloadConfig();

        $this->getLogger()->info("Successfully loaded!");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

    }

    public function onHeld(PlayerItemHeldEvent $e){

        $it = $e->getItem();
        $p = $e->getPlayer();

        if($it->getID() === $this->getConfig()->getNested("Sneak.ID")){

            $p->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_SNEAKING, true);

            if($this->getConfig()->get("ShowMessage") === "true"){

                Server::getInstance()->broadcastMessage($this->getConfig()->get("SneakMessage"));

            }else{

                Server::getInstance()->broadcastMessage("");

            }

        }elseif($it->getID() === $this->getConfig()->getNested("unSneak.ID")){

            $p->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_SNEAKING, false);

            if($this->getConfig()->get("ShowMessage") === "true"){

                Server::getInstance()->broadcastMessage($this->getConfig()->get("unSneakMessage"));

            }else {

                Server::getInstance()->broadcastMessage("");

            }

        }
        
    }

    public function onDisable(){

        $this->getLogger()->info("unLoaded...");

    }

}
