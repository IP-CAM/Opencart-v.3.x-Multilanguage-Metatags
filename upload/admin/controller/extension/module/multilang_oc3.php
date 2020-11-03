<?php

class ControllerExtensionModuleMultilangOc3 extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('extension/module/multilang_oc3');

        $this->document->setTitle($this->language->get('heading_main_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('multilang_oc3', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }

        if (isset($this->error['language'])) {
            $data['error_language'] = $this->error['language'];
        } else {
            $data['error_language'] = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['user_token'], true),
            'separator' => false,
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['user_token'] . '&type=module', true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/multilang_oc3', 'token=' . $this->session->data['user_token'], true),
        );

        $this->load->model('extension/module/multilang_oc3');

        $data['languages'] = $this->model_extension_module_multilang_oc3->getLanguages();

        if (isset($this->request->post['multilang_oc3_data'])) {
            $data['multilang_oc3_data'] = $this->request->post['multilang_oc3_data'];
        } elseif ($this->config->get('multilang_oc3_data')) {
            $data['multilang_oc3_data'] = $this->config->get('multilang_oc3_data');
        } else {
            $data['multilang_oc3_data'] = array();
        }

        if (isset($this->request->post['multilang_oc3_code'])) {
            $data['multilang_oc3_code'] = $this->request->post['multilang_oc3_code'];
        } elseif ($this->config->get('multilang_oc3_code')) {
            $data['multilang_oc3_code'] = $this->config->get('multilang_oc3_code');
        } else {
            $data['multilang_oc3_code'] = array();
        }

        if (isset($this->request->post['multilang_oc3_language'])) {
            $data['multilang_oc3_language'] = $this->request->post['multilang_oc3_language'];
        } elseif ($this->config->get('multilang_oc3_language')) {
            $data['multilang_oc3_language'] = $this->config->get('multilang_oc3_language');
        } else {
            $data['multilang_oc3_language'] = '';
        }

        $data['action'] = $this->url->link('extension/module/multilang_oc3', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/multilang_oc3', $data));
    }

    public function install() {
        $this->load->model('extension/module/multilang_oc3');

        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'extension/module/multilang_oc3');
        $this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'extension/module/multilang_oc3');

        $this->model_extension_module_multilang_oc3->makeDB();

        if (!in_array('multilang_oc3', $this->model_setting_extension->getInstalled('module'))) {
            $this->model_setting_extension->install('module', 'multilang_oc3');
        }

        $this->session->data['success'] = $this->language->get('text_success_installed');
    }

    public function uninstall() {
        $this->load->model('extension/module/multilang_oc3');

        $this->model_extension_module_multilang_oc3->removeDB();

        $this->model_setting_extension->uninstall('module', 'multilang_oc3');
        $this->model_setting_setting->deleteSetting('multilang_oc3_data');
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/multilang_oc3')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['multilang_oc3_code'] as $key => $code) {
            if ((utf8_strlen($code) < 2) || (utf8_strlen($code) > 32)) {
                $this->error['code'][$key] = $this->language->get('error_code');
            }
        }

        if (!$this->request->post['multilang_oc3_language']) {
            $this->error['language'] = $this->language->get('error_language');
        }

        return !$this->error;
    }
}