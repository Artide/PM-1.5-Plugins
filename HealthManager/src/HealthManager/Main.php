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

    public $pfx = "[HealthManager]";

    public function onEnable(){

        $log = $this->getLogger();

        $log->info("Plugin successfully loaded!");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->saveDefaultConfig();
        $this->reloadConfig();

    }

    public function helpList($player){

        $player->sendMessage(TXT::GREEN . $this->pfx);
        $player->sendMessage(TXT::GREEN . "/sethealth <player> <health> : set a players health.");
        $player->sendMessage(TXT::GREEN . "/savehealth <player> <health> : save a players health to the config.");
        $player->sendMessage(TXT::GREEN . "/randhealth <player> <number1> <number2> : sets a players help to a random number between number1 and number 2.");
        $player->sendMessage(TXT::GREEN . "/delhealth <player> : delete health from the config.");

        return true;

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

                    if ($sender->hasPermission("hm.sethealth")) {

                        if (isset($args[0]) && isset($args[1])) {

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

                    if ($sender->hasPermission("hm.savehealth")) {

                        if (isset($args[0]) && isset($args[1])) {

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if (is_numeric($args[1])) $player->setHealth($args[1]);

                                $this->getConfig()->setNested("Players", [$player->getName() => $args[1]]);
                                $this->getConfig()->save();

                                $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health saved. When they join they will have the same health as you saved it.");

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

                    if ($sender->hasPermission("hm.randhealth")) {

                        if (isset($args[0]) && isset($args[1]) && isset($args[2])) {

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if (is_numeric($args[1]) && is_numeric($args[2])) {

                                    $rand = $args[1];
                                    $rand2 = $args[2];

                                    $result = mt_rand($rand, $rand2);

                                    $player->setHealth($result);

                                    $sender->sendMessage(TXT::GREEN . $player->getName() . "'s health set to " . TXT::RED . $result . ".");

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

                case 'gethealth':

                    if ($sender->hasPermission("hm.gethealth")) {

                        if (isset($args[0])) {

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

                case 'delhealth':

                    if ($sender->hasPermission("hm.delhealth")) {

                        if (isset($args[0])) {

                            if ($this->getServer()->getPlayerExact($args[0])) {

                                $player = $this->getServer()->getPlayerExact($args[0]);

                                if($this->getConfig()->getAll()["Players"][$player->getName()] !== null) {

                                    $c = $this->getConfig()->get("Players");
                                    unset($c[$player->getName()]);
                                    $this->getConfig()->set("Players", $c);
                                    $this->getConfig()->save();

                                    $sender->sendMessage(TXT::GREEN . "Players config was deleted.");

                                    return true;

                                }else{

                                    $sender->sendMessage(TXT::RED . "Player not found in config.");

                                }

                                if (empty($args[1]) || empty($args[0])) $sender->sendMessage(TXT::RED . "Usage: /delhealth <player>");

                                return true;

                            }else{

                                $sender->sendMessage(TXT::RED . "Player is offline.");

                                return true;

                            }

                        }

                    }
                    break;

                case 'healthmanager':

                    if ($sender->hasPermission("hm.help")) {

                        if (isset($args[0])) {

                            $args[0] = "help" || "h" || "?";

                            $this->helpList($sender);

                            return true;

                        }else{

                            $sender->sendMessage(TXT::RED . "Usage: /healthmanager <help|h|?>");

                            return true;

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

        $c = $this->getConfig()->getAll();

        if($c["Players"][$p->getName()] !== null){
            
            $p->setHealth($c["Players"][$p->getName()]);

            $p->sendMessage(TXT::GREEN . "Your health was set to " . TXT::RED . $c["Players"][$p->getName()] . TXT::GREEN . " by an admin.");

            return true;

        }else{

            $this->getLogger()->info($p->getName() . " not found in config.");

        }

    }

}
