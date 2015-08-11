<?php

namespace DEN;

use DEN\Timer\Timer;
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

class Main extends PluginBase implements Listener{

    const pfx = "[Annihilation]";
    const error = "[ERROR]";

    /*@Timer task@*/

    private $task;
    public $blue = "blue";
    public $green = "green";
    public $red = "red";
    public $yellow = "yellow";
    public $players = 0;
    public $pts = 75;
    public $max = 10;
    public $min = 5;

    public function onEnable($msg = "Plugin enabled")
    {

        $this->getLogger()->info($msg);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        mkdir($this->getDataFolder());
        $this->savedefaultConfig();
        $this->reloadConfig();

        $cfg = $this->getConfig();

        $stime = intval($cfg->get("StartTime")) * 1200;
        $ftimeone = intval($cfg->get("PhaseTimeOne")) * 1200;
        $ftimetwo = intval($cfg->get("PhaseTimeTwo")) * 1200;
        $ftimethree = intval($cfg->get("PhaseTimeThree")) * 1200;
        $ftimefour = intval($cfg->get("PhaseTimeFour")) * 1200;

        $this->getServer()->getScheduler()->scheduleRepeatingTask($starttimer = new Timer($this), $stime);
        $this->getServer()->getScheduler()->scheduleRepeatingTask($fasetimerone = new Timer($this), $ftimeone);
        $this->getServer()->getScheduler()->scheduleRepeatingTask($fasetimertwo = new Timer($this), $ftimetwo);
        $this->getServer()->getScheduler()->scheduleRepeatingTask($fasetimethree = new Timer($this), $ftimethree);
        $this->getServer()->getScheduler()->scheduleRepeatingTask($fasetimefour = new Timer($this), $ftimefour);
        $this->getServer()->getScheduler()->scheduleRepeatingTask($this->task = new Timer($this), 20);

    }

}