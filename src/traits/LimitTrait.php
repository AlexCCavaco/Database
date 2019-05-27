<?php
namespace DB\traits;

/**
 * Trait for DB Where Functions
 * --
 * Class WhereTrait
 * @package Database\traits
 */
trait LimitTrait {

    /**
     * @var string|int
     */
    protected $limit;

    /**
     * @param string|int $limit
     * @return $this
     */
    public function limit($limit){ $this->limit = $limit; return $this; }

    /**
     * @return $this
     */
    public function first(){ $this->limit = 1; return $this; }

}
