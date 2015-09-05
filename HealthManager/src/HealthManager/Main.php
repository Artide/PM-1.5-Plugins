<?php

namespace HealthManager;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(){

        $log = $this->getLogger();

        $log->info("Plugin successfully loaded!");


    }

    public function onCommand(Command $command, CommandSender $sender, $label, array $args){

            switch(strtolower($command->getName())) {

                case 'sethealth':

                    if($sender->hasPermission("hm.sethealth")) {

                        if(isset($args[0])) $player = $this->getServer()->getPlayerExact($args[0]);

                        if (isset($args[1]) && is_numeric($args[1])) $player->setHealth($args[1]);

                        $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health set to " . TXT::RED . $args[1]);

                        if (!is_numeric($args[1])) $sender->sendMessage(TXT::RED . "Invalid number.");

                        if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /sethealth <player> <health>");

                        if ($player === null) $sender->sendMessage(TXT::RED . $player->getName() . " is offline.");

                        return true;

                    }

                    break;

                case 'savehealth':

                    if($sender->hasPermission("hm.savehealth")) {

                        if(isset($args[0])) $player = $this->getServer()->getPlayerExact($args[0]);

                        if (isset($args[1]) && is_numeric($args[1])) $player->setHealth($args[1]);

                        $health = new Config($this->getDataFolder() . "players/" . strtolower($player->getName()) . ".yml", Config::YAML);

                        if ($health->exists("Health")) {

                            $health->set("Health", $args[0]);
                            $health->save();

                            $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health saved. When they join\n they will have the same health you set it to.");

                            return true;

                        }

                        if (!is_numeric($args[1])) $sender->sendMessage(TXT::RED . "Invalid number.");

                        if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /savehealth <player> <health>");

                        return true;

                    }
                    break;

                case 'randhealth':

                    if($sender->hasPermission("hm.randhealth")) {

                        if(isset($args[0])) $player = $this->getServer()->getPlayerExact($args[0]);

                        if (isset($args[1]) && isset($args[2]) && is_numeric($args[1]) && is_numeric($args[2]) && $args[1] < $args[2]) {

                            $rand = $args[1];
                            $rand2 = $args[2];
                            $result = mt_rand($rand, $rand2);

                            $player->setHealth($result);

                            $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health set to " . $result);

                            return true;

                        } elseif ($args[1] > $args[2]) {

                            $sender->sendMessage(TXT::RED . "First number can't be bigger than second number.");
                            return true;

                        }

                        if (!is_numeric($args[1])) $sender->sendMessage(TXT::RED . "Invalid number.");

                        if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /randhealth <player> <number1> <number2>");

                        if ($player === null) $sender->sendMessage(TXT::RED . $player->getName() . " is offline.");

                        return true;

                    }
                    break;

                case 'gethealth':

                    if($sender->hasPermission("hm.gethealth")) {

                        if(isset($args[0])) $player = $this->getServer()->getPlayerExact($args[0]);

                        $phealth = $player->getHealth();

                        $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health is " . $phealth);

                        if (empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /gethealth <player>");

                        if ($player === null) $sender->sendMessage(TXT::RED . $player->getName() . " is offline.");

                        return true;

                    }
                break;

            }

    }

    public function onJoin(PlayerJoinEvent $e){

        $p = $e->getPlayer();

        $health = new Config($this->getDataFolder() . "players/" . strtolower($p->getName()) . ".yml", Config::YAML);

        if($health->exists("Health")){

            $p->setHealth($health->get("Health"));

            $p->sendMessage(TXT::GREEN . "Your health was set to " . $health->get("Healt") . " by an admin.");

            return true;

        }else{

            return false;

        }

    }

}
