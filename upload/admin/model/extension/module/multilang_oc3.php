<?php

class ModelExtensionModuleMultilangOc3 extends Model {

    public function makeDB() {
        $sql = "ALTER TABLE `" . DB_PREFIX . "language` ADD `url` VARCHAR(32) NOT NULL AFTER `code`";
        $this->db->query($sql);

    }

    public function removeDB() {
        $sql = "ALTER TABLE `" . DB_PREFIX . "language` DROP COLUMN `url`";
        $this->db->query($sql);
    }

    public function getLanguages() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

        return $query->rows;
    }
}