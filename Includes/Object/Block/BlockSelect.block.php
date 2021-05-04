<?php

namespace Block;

/**
 * BlockSelect
 */
class BlockSelect
{
    /**
     * Returns pre-defined columns which will be selected
     */
    public function user()
    {
        return 'u.user_id, u.user_name, u.user_profile_image, u.is_deleted, u.user_last_activity, g.group_class_name';
    }
}