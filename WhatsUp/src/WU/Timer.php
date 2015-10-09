<?php

namespace WU;

use WU\Colors;
use pocketmine\scheduler\PluginTask;

class Timer extends PluginTask{

    /**
     * @param WU $plugin
     */
    public function __construct(WU $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    /**
     * @param $tick
     */
    public function onRun($tick)
    {
        $cfg = $this->plugin->getConfig();
        $this->plugin->secs--;
        if($this->plugin->secs === 0){
            $color = [$cfg->get("Format"), $cfg->get("Join_Format")];
            $colors = new Colors();
            str_replace("@rb", $colors->randomColor(), $color);
            $this->plugin->secs += $this->plugin->sbu;
        }
    }
}
