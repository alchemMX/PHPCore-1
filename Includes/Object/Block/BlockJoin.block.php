<?php

namespace Block;

/**
 * BlockJoin
 */
class BlockJoin
{
    /**
     * Returns user join statement
     * 
     * @param string $on On value
     * 
     * @return string
     */
    public function user( string $on )
    {
        return 'LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = ' . $on . ' LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id';
    }
}