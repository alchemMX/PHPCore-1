<?php

namespace Block;

/**
 * Other
 */
class Other extends Block
{    
    /**
     * Returns database version
     *
     * @return string
     */
    public function version()
    {
        return $this->db->query('SELECT VERSION() AS version')['version'];
    }
}