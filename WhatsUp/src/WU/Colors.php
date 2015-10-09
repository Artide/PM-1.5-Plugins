<?php

namespace WU;

use pocketmine\utils\TextFormat as TXT;

class Colors{

    /**
     * @param $number
     * @return mixed
     */
    public function switchColor($number)
    {
        switch($number){
            case 0:
                return TXT::BLACK;
                break;
            case 1:
                return TXT::DARK_BLUE;
                break;
            case 2:
                return TXT::DARK_GREEN;
                break;
            case 3:
                return TXT::DARK_AQUA;
                break;
            case 4:
                return TXT::DARK_RED;
            case 5:
                return TXT::DARK_PURPLE;
                break;
            case 6:
                return TXT::GOLD;
                break;
            case 7:
                return TXT::GRAY;
                break;
            case 8:
                return TXT::DARK_GRAY;
                break;
            case 9:
                return TXT::BLUE;
                break;
            case 10:
                return TXT::GREEN;
                break;
            case 11:
                return TXT::AQUA;
                break;
            case 12:
                return TXT::RED;
                break;
            case 13:
                return TXT::LIGHT_PURPLE;
                break;
            case 14:
                return TXT::YELLOW;
                break;
            case 15:
                return TXT::WHITE;
                break;
        }
    }

    /**
     * @return mixed
     */
    public function randomColor()
    {
        return self::switchColor(mt_rand(0, 15));
    }
}
