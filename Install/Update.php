<?php

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_BUTTONS)[0] . '
    ADD COLUMN IF NOT EXISTS button_icon varchar(225) NOT NULL DEFAULT "",
    ADD COLUMN IF NOT EXISTS button_icon_style varchar(225) NOT NULL DEFAULT ""
');