<?php

namespace HealthManager;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
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

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        @mkdir($this->getDataFolder() . "/players");

        $this->saveDefaultConfig();
        $this->reloadConfig();

    }

    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $command, $label, array $args){

            switch(strtolower($command->getName())) {

                case 'sethealth':

                    if($sender->hasPermission("hm.sethealth")) {

                        if (isset($args[0]) && isset($args[1])){

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if (is_numeric($args[1])) $player->setHealth($args[1]);

                                $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health set to " . TXT::RED . $args[1]);

                                if (!is_numeric($args[1])) $sender->sendMessage(TXT::RED . "Invalid number.");

                                if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /sethealth <player> <health>");

                                return true;

                            } else {

                                $sender->sendMessage(TXT::RED . "Player is offline.");

                                return true;

                            }

                        }

                    }
                    break;

                case 'savehealth':

                    if($sender->hasPermission("hm.savehealth")) {

                        if(isset($args[0]) && isset($args[1])) {

                            if ($player = $this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if (is_numeric($args[1])) $player->setHealth($args[1]);

                                $health = new \Config($this->getDataFolder() . "/players" . strtolower($player->getName()) . ".yml", Config::YAML,
                                    [
                                    "Health" => $args[1],
                                    "Admin" => $sender->getName(),
                                    ]
                                );

                                if ($health->exists("Health")) {

                                    $health->set("Health", $args[1]);
                                    $health->save();

                                    $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health saved. When they join\n they will have the same health you set it to.");

                                    return true;

                                }

                                if (!is_numeric($args[1])) $sender->sendMessage(TXT::RED . "Invalid number.");

                                if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /savehealth <player> <health>");

                                return true;

                            } else {

                                $sender->sendMessage(TXT::RED . "Player is offline.");

                                return true;

                            }

                        }

                    }
                    break;

                case 'randhealth':

                    if($sender->hasPermission("hm.randhealth")) {

                        if(isset($args[0]) && isset($args[1]) && isset($args[2])) {

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if (is_numeric($args[1]) && is_numeric($args[2]) && $args[1] < $args[2]) {

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

                                return true;

                            } else {

                                $sender->sendMessage(TXT::RED . "Player is offline.");

                                return true;

                            }

                        }

                    }
                    break;

                case 'gethealth':

                    if($sender->hasPermission("hm.gethealth")) {

                        if(isset($args[0])) {

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $player = $this->getServer()->getPlayerExact($args[0]);

                                $phealth = $player->getHealth();

                                $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health is " . $phealth);

                                if (empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /gethealth <player>");

                                return true;

                            } else {

                                $sender->sendMessage(TXT::RED . "Player is offline.");

                                return true;

                            }

                        }

                    }
                break;

            }

    }

    /**
     * @param PlayerJoinEvent $e
     * @return bool
     */
    public function onPlayerJoin(PlayerJoinEvent $e){

        $p = $e->getPlayer();

        $health = new \Config($this->getDataFolder() . "/players" . strtolower($p->getName()) . ".yml", Config::YAML);

        if(method_exists($health, "Health") && method_exists($health, "Admin") && file_exists($health)){

            $p->setHealth($health->get("Health"));

            $p->sendMessage(TXT::GREEN . "Your health was set to" . TXT::RED . $health->get("Healt") . TXT::GREEN . ".\n by the admin " . TXT::RED . $health->get("Admin") . ".");

            return true;

        }else{

            return false;

        }

    }

}
