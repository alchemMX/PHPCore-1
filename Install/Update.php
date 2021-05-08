<?php

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS)[0] . ' DROP COLUMN IF EXISTS profile_post_edited');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS)[0] . ' DROP COLUMN IF EXISTS is_edited');

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS_COMMENTS)[0] . ' DROP COLUMN IF EXISTS profile_post_comment_edited');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS_COMMENTS)[0] . ' DROP COLUMN IF EXISTS is_edited');