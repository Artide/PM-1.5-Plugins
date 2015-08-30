<?php

namespace DEN\Task;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat as TXT;
use pocketmine\event\entity\EntityDamageEvent;

use DEN\Main;

class TeleportPlayers{

    public function __construct(Teams $plugin, Main $main){

        $this->plug = $plugin;
        $this->main = $main;

    }

    /**
     * @param Player $p
     * @param $time
     */
    public function teleport(Player $p, $time){

        $cfg = $this->getConfig();
        $cfga = $this->getConfig()->getAll();

        $lvl = $cfg->get(array("ArenaList"));
        $yellowspawn = [$cfg->get("YellowSpawnX"),$cfg->get("YellowSpawnY"),$cfg->get("YellowSpawnZ")];
        $redspawn = [$cfg->get("RedSpawnX"),$cfg->get("RedSpawnY"),$cfg->get("RedSpawnZ")];
        $greenspawn = [$cfg->get("GreenSpawnX"),$cfg->get("GreenSpawnY"),$cfg->get("GreenSpawnZ")];
        $bluespawn = [$cfg->get("BlueSpawnX"),$cfg->get("BlueSpawnY"),$cfg->get("BlueSpawnZ")];


        if($this->plug->yellow($p) && $this->main->stime($time) === 0){

            $p->teleport(new Postition($yellowspawn,$lvl));

            if($cfga["JoinedYellowMessage"]["Show"] === "true"){

                $p->sendMessage($cfg->get("JoinedYellowMessage"));

            }elseif($cfga["JoinedYellowMessage"]["Show"] === "false"){

                return false;

            }

        }

        if($this->plug->red($p) && $this->main->stime($time) === 0){

            $p->teleport(new Postition($bluespawn,$lvl));

            if($cfga["JoinedRedMessage"]["Show"] === "true"){

                $p->sendMessage($cfg->get("JoinedRedMessage"));

            }elseif($cfga["JoinedRedMessage"]["Show"] === "false"){

                return false;

            }

        }

        if($this->plug->geen($p) && $this->main->stime($time) === 0){

            $p->teleport(new Postition($bluespawn,$lvl));

            if($cfga["JoinedGreenMessage"]["Show"] === "true"){

                $p->sendMessage($cfg->get("JoinedGreenMessage"));

            }elseif($cfga["JoinedGreenMessage"]["Show"] === "false"){

                return false;

            }

        }

        if($this->plug->blue($p) && $this->main->stime($time) === 0){

            $p->teleport(new Postition($bluespawn,$lvl));

            if($cfga["JoinedBlueMessage"]["Show"] === "true"){

                $p->sendMessage($cfg->get("JoinedBlueMessage"));

            }elseif($cfga["JoinedBlueMessage"]["Show"] === "false"){

                return false;

            }

        }

    }

}
