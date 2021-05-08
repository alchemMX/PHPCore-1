<?php

$this->db->query('ALTER TABLE ' . TABLE_PROFILE_POSTS . ' DROP COLUMN IF EXISTS profile_post_edited');
$this->db->query('ALTER TABLE ' . TABLE_PROFILE_POSTS . ' DROP COLUMN IF EXISTS is_edited');

$this->db->query('ALTER TABLE ' . TABLE_PROFILE_POSTS_COMMENTS . ' DROP COLUMN IF EXISTS profile_post_comment_edited');
$this->db->query('ALTER TABLE ' . TABLE_PROFILE_POSTS_COMMENTS . ' DROP COLUMN IF EXISTS is_edited');