<?php

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_POSTS_LIKES)[0] . ' CHANGE COLUMN IF EXISTS `like_time` like_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_TOPICS_LIKES)[0] . ' CHANGE COLUMN IF EXISTS `like_time` like_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');