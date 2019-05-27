<?php
namespace DB\traits;

use DB\lib\DBList;

/**
 * Trait for DB Where Functions
 * --
 * Class OrderByTrait
 * @package Database\traits
 */
trait OrderByTrait {

    /**
     * @param array|string ...$vars
     * @return $this
     */
    public function orderBy(...$vars){
        foreach($vars as $var){
            if(is_array($var)) $this->order->addAll($var);
            else $this->order->add($var);
        }
        return $this;
    }

}
