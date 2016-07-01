<?php
class ControllerModuleMailchimpsubscription extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/mailchimpsubscription');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			
			if (!isset($this->request->get['module_id'])) {
				
				$this->model_extension_module->addModule('mailchimpsubscription', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_module_type'] = $this->language->get('text_module_type');
		$data['text_popup'] = $this->language->get('text_popup');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['help_title'] = $this->language->get('help_title');
		$data['entry_success_message'] = $this->language->get('entry_success_message');
		$data['help_success_message'] = $this->language->get('help_success_message');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['help_description'] = $this->language->get('help_description');
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['entry_type'] = $this->language->get('entry_type');
		$data['help_type'] = $this->language->get('help_type');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['help_image'] = $this->language->get('help_image');
		$data['entry_delay'] = $this->language->get('entry_delay');
		$data['help_delay'] = $this->language->get('help_delay');
		$data['entry_unsubscribe'] = $this->language->get('entry_unsubscribe');
		$data['entry_only_once'] = $this->language->get('entry_only_once');
		$data['help_only_once'] = $this->language->get('help_only_once');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['entry_list_id1'] = $this->language->get('entry_list_id1');
		$data['entry_mailchimp_api_key'] = $this->language->get('entry_mailchimp_api_key');
		$data['entry_list_id2'] = $this->language->get('entry_list_id2');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/mailchimpsubscription', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/mailchimpsubscription', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/mailchimpsubscription', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/mailchimpsubscription', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);	
		}
		//print_r($module_info); 
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['mailchimp_api_key'])) {
			$data['mailchimp_api_key'] = $this->request->post['mailchimp_api_key'];
		} elseif (!empty($module_info)) {
			$data['mailchimp_api_key'] = $module_info['mailchimp_api_key'];
		} else {
			$data['mailchimp_api_key'] = '';
		}
		
		if (isset($this->request->post['mc_list_id1'])) {
			$data['mc_list_id1'] = $this->request->post['mc_list_id1'];
		} elseif (!empty($module_info)) {
			$data['mc_list_id1'] = $module_info['mc_list_id1'];
		} else {
			$data['mc_list_id1'] = '';
		}
		
		if (isset($this->request->post['mc_list_id2'])) {
			$data['mc_list_id2'] = $this->request->post['mc_list_id2'];
		} elseif (!empty($module_info)) {
			$data['mc_list_id2'] = $module_info['mc_list_id2'];
		} else {
			$data['mc_list_id2'] = '';
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer'); 
		$this->response->setOutput($this->load->view('module/mailchimpsubscription.tpl', $data));
	}
	

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/mailchimpsubscription')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		
				
		return !$this->error;
	}
	
	public function install() {
		$this->load->model('module/mailchimpsubscription');
		$this->model_module_mailchimpsubscription->createDatabaseTable();
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'sale/subscriber');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'sale/subscriber');
	}

	public function uninstall() {
		$this->load->model('module/mailchimpsubscription');
		$this->model_module_mailchimpsubscription->dropDatabaseTable();
	}
	
}