<?php

namespace blockreset;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TXT;

class BlockReset extends PluginBase implements Listener{


    /**
     * @var $taskId
     */
    public $taskId;
    /**
     * @var $min
     */
    public $min;
    /**
     * @var $sec
     */
    public $sec;
    /**
     * @var int
     */
    public $mbu = 0;
    /**
     * @var int
     */
    public $sbu = 0;

    public function onEnable()
    {
        $log = $this->getLogger();
        $log->info("BlockReset successfully enabled!");

        $this->min = $this->getConfig()->get("RESET_BLOCK_MINUTES");
        $this->sec = $this->getConfig()->get("RESET_BLOCK_SECONDS");
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new Task($this), 20 * $this->sec);
        $this->mbu += $this->min;
        $this->sbu += $this->sec;
    }

    /**
     * @param $pos
     * @param $world
     * @param $blockId
     * @param $meta
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public function resetBlock($pos, $world, $blockId, $meta, $message)
    {
        foreach($this->getServer()->getOnlinePlayers() as $p){
            if($message !== null) {
                $p->sendMessage($message);
            }
        }
        if(is_int($meta)) {
            return $this->getServer()->getLevelByName($world)->setBlock(new Vector3($pos),Block::get($blockId, $meta));
        }else{
            throw new \Exception(printf("%s is not an int", $meta));
        }
    }

    /**
     * @param $pos
     * @param $world
     * @return
     * @throws \Exception
     */
    public function deleteBlock($pos, $world)
    {
        if($pos !== null || $world !== null){
            return $this->getServer()->getLevelByName($world)->setBlock(new Vector3($pos),Block::get(0, 0));
        }else{
            $null = null ? $pos : $world;
            throw new \Exception(printf("%s is null", $null));
        }
    }

    /**
     * @param $cf
     * @return
     * @throws \Exception
     */
    public function resetBlockFromCFG($cf)
    {
        if($cf !== null) {
            $cfg = $this->getConfig()->get($cf);
            foreach ($cfg as $c) {
                list($world, $x, $y, $z, $blockId, $meta) = explode(":", $c);
                return $this->getServer()->getLevelByName($world)->setBlock(new Vector3($x, $y, $z), Block::get($blockId, $meta));
            }
        }else{
            throw new \Exception(printf("%s is null", $cf));
        }
    }
}
