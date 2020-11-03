<?php

class ModelExtensionModuleMultilangOc3 extends Model {

    public function getLanguages() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

        return $query->rows;
    }
}