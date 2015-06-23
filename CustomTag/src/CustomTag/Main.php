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

namespace CustomTag;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\Level;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;


class Main extends PluginBase implements Listener{

    pubic function __construct(CustomTag $plugin){


    $config = $this->getConfig();

    $economys = EconomyAPI::getInstance();

    public function onEnable(){

        $this->version = $this->getDescription->getVersion();

        $this->getLogger()->info("Plugin loaded! version ".$this->version);

        $this->saveDefaultConfig();
        $this->reloadConfig();

        $this->getServer()->getPluginManager()->registeEvents($this, $this);

    }

    public function moneyTag(Player $p, $tag){

        $tag = str_replace("{MONEY}", $economys->getAllMoney($p), $tag);

        $tag = str_replace("{NAME}", $p->getDisplayName(), $tag);

        $tag = str_replace("{FORMAT}", $config->get("NameTagFormat"), $tag);

        return $tag;

    }

    public function setTag(Player $p){

        $p->setNameTag($config->get("NameTagFormat"));

        if($config->get("MessageType") === "tip") {

            $p->sendTip($config->get("Message"));

        }elseif($config->get("MessageType") === "popup"){

            $p->sendPopup($config->get("Message"));

        }elseif("MessageType") === "msg"){

            $p->sendMessage($config->get("Message"));

            return true;

        }

    }

    public function onJoin(PlayerJoinEvent $e){

        $this->setTag();

        $this->moneyTag();

    }

    public function onDisable(){

        $this->getLogger()->info("Plugin disabled!");

    }

}
