<?php

namespace RandTeleport;

use pocketmine\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\math\Vector3;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
class RandTP extends PluginBase
{

    const SMALL_TP = 0;
    const MEDIUM_TP = 1;
    const RANDOM_TP = 3;
    const FAR_TP = 4;

    public function onEnable()
    {
        $log = $this->getLogger();
        $log->info("Plugin successfully loaded!");
        $this->saveDefaultConfig();
        $this->reloadConfig();
    }

    /**
     * @param $p
     * @param $type
     * @return mixed
     */
    public function toRand($p, $type){
        switch($type){
            case self::SMALL_TP:
                return $p->teleport($p->getLevel()->getSafeSpawn(new Vector3(mt_rand(0, 100), mt_rand(0, 127), mt_rand(0, 100))));
            break;
            case self::MEDIUM_TP:
                return $p->teleport($p->getLevel()->getSafeSpawn(new Vector3(mt_rand(0, 500), mt_rand(0, 127), mt_rand(0, 500))));
            break;
            case self::RANDOM_TP:
                return $p->teleport($p->getLevel()->getSafeSpawn(new Vector3(mt_rand(0, 1000), mt_rand(0, 127), mt_rand(0, 1000))));
            break;
            case self::FAR_TP:
                return $p->teleport($p->getLevel()->getSafeSpawn(new Vector3(mt_rand(0, 5000), mt_rand(0, 127), mt_rand(0, 5000))));
            break;
        }
    }

    /**
     * @param CommandSender $sender
     * @param Command $cmd
     * @param $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
        switch(strtolower($cmd->getName())) {
            case 'rand':
                foreach($this->getConfig()->get("Worlds") as $world) {
                    if ($sender->hasPermission("randtp.rand")) {
                        if ($sender instanceof Player && $sender->getLevel()->getName() !== $world) {
                            self::toRand($sender, self::RANDOM_TP);
                            $sender->sendMessage(TXT::AQUA . "Teleported to X: " . TXT::YELLOW . $sender->getX()
                                . TXT::AQUA . ", Y: " . TXT::YELLOW . $sender->getY() . TXT::AQUA . " Z: " . TXT::YELLOW . $sender->getX());
                        } elseif(!$sender instanceof Player) {
                            $sender->sendMessage(TXT::RED . "Please run this command in game.");
                            return true;
                        }elseif($sender->getLevel()->getName() === $world){
                            $sender->sendMessage(TXT::RED . "You are not allowed to use that command in this world.");
                            return true;
                        }
                    }
                }
                break;
        }
    }
}
