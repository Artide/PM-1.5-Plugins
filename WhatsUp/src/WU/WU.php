<?php

namespace WU;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\event\player\PlayerJoinEvent;

class WU extends PluginBase implements Listener{

    public function onEnable()
    {
        $log = $this->getLogger();
        $log->info(TXT::GREEN . "Plugin enabled!");
        $this->saveDefaultConfig();
        $this->reloadConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "WhatsUp");
    }

    /**
     * @param $player
     * @param $message
     * @return mixed
     */
    public function WhatsUp($player, $message)
    {
        $format = $this->getConfig()->get("Format");
        return $player->setNameTag(str_replace(["@player", "@whats_up"], [$player->getName(), $message], $format));
    }

    /**
     * @param $player
     * @param $message
     */
    public function saveStatus($player, $message)
    {
        @mkdir($this->getDataFolder());
        file_put_contents($this->getDataFolder() . "WhatsUp/" . $player->getName() . ".yml", yaml_emit(["Status" => implode(" ", $message)]));
        if(!empty($message)) {
            $player->sendMessage(TXT::GREEN . "Successfully saved status as '" . implode(" ", $message) . "'.");
        }else{
            return;
        }
        return;
    }

    /**
     * @param $player
     */
    public function deleteStatus($player)
    {
        if(file_exists($this->getDataFolder() . "WhatsUp/" . $player->getName() . ".yml")){
            unlink($this->getDataFolder() . "WhatsUp/" . $player->getName() . ".yml");
            $player->sendMessage(TXT::GREEN . "Successfully deleted status.");
        }else{
            $player->sendMessage(TXT::RED . "No status found for you. :(");
        }
        return;
    }

    /**
     * @param CommandSender $p
     * @param Command $c
     * @param $label
     * @param array $args
     */
    public function onCommand(CommandSender $p, Command $c, $label, array $args)
    {
        switch(strtolower($c->getName())) {
            //case 'whatsup':
            case 'wu':
                if ($p->hasPermission("wu.wu")) {
                    if ($p instanceof Player) {
                        $this->WhatsUp($p, implode(" ", $args));
                        $p->sendMessage(TXT::GREEN . "Status set to '" . implode(" ", $args) . "'.");
                    } else {
                        $p->sendMessage(TXT::RED . "Please run this command in-game.");
                    }
                    if (empty($args) || count($args) === 0) {
                        $p->sendMessage(TXT::RED . "Failed to set status. Usage: /wu <status>");
                    } else {
                        return;
                    }
                }
                break;
            //case 'savestatus':
            case 'ss':
                if ($p->hasPermission("wu.ss")) {
                    if ($p instanceof Player) {
                        $this->WhatsUp($p, implode(" ", $args));
                        $this->saveStatus($p, $args);
                    } else {
                        $p->sendMessage(TXT::RED . "Please run this command in-game.");
                    }
                    if (empty($args) || count($args) === 0) {
                        $p->sendMessage(TXT::RED . "Failed to set status. Usage: /ss <status>");
                    } else {
                        return;
                    }
                }
            break;
            //case 'delstatus':
            case 'ds':
                if ($p->hasPermission("wu.ds")) {
                    if ($p instanceof Player) {
                        $this->deleteStatus($p);
                    } else {
                        $p->sendMessage(TXT::RED . "Please run this command in-game.");
                    }
                }
            break;
        }
    }

    /**
     * @param PlayerJoinEvent $e
     */
    public function onPlayerJoin(PlayerJoinEvent $e)
    {
        $p = $e->getPlayer();
        $format = $this->getConfig()->get("Join_Format");
        if(file_exists($this->getDataFolder() . "WhatsUp/" . $p->getName() . ".yml")){
            $status = new Config($this->getDataFolder() . "WhatsUp/" . $p->getName() . ".yml", Config::YAML);
            $p->setNameTag(str_replace(["@player", "@saved_status"], [$p->getName(), $status->get("Status")], $format));
            $p->sendMessage(TXT::GREEN . "Status set to '" . $status->get("Status") . "'.");
        }else{
            return;
        }
    }
}
