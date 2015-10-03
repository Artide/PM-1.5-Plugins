<?php

namespace blockreset;

use pocketmine\scheduler\PluginTask;

class Timer extends PluginTask{

    public function __construct(BlockReset $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    /**
     * @param $tick
     */
    public function onRun($tick)
    {
        $this->plugin->sec--;
        if($this->plugin->sec <= 1){
            $this->plugin->sec = $this->plugin->sbu;
            $this->plugin->min--;
            if($this->plugin->min === 0 && $this->plugin->sec === 0){
                $this->plugin->resetBlockFromCFG("BLOCK_RESET_LIST");
                $this->plugin->sec = $this->plugin->sbu;
                $this->plugin->min = $this->plugin->mbu;
            }
        }
    }
}
