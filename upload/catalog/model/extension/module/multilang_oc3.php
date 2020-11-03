<?php

class ModelExtensionModuleMultilangOc3 extends Model {

    public function getLanguages() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

        return $query->rows;
    }

    public function getLanguageUrl($language_id) {
        $query = $this->db->query("SELECT url FROM " . DB_PREFIX . "language WHERE language_id = '" . (int) $language_id . "'");

        return $query->row['url'];
    }
}