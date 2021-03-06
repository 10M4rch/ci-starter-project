<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends Admin_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->helper(array('language'));

    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load(array('auth', 'ion_auth'));

  }

  public function index()
  {
    if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

      $this->activate_user_link();

      $this->template->set('title', 'Admin | User Management');
			$this->template->load('admin/templates/user_management','admin/user_management/list', $this->data);
		}
  }

  // Manual user activation
  public function activate($id)
  {
    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
      return show_error("Kamu harus menjadi admin untuk melakukan aksi ini.");
    } elseif ($this->ion_auth->is_admin()) {
      $activation = $this->ion_auth->activate($id);
    }

    if ($activation) {
      $this->session->set_flashdata('message', "<div style='color:#00a65a'>" . $this->ion_auth->messages() . "</div>");
      redirect(site_url('admin/user_management'));
    }
  }

  // Manual user deactivation
  public function deactivate($id)
  {
    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
    {
      // redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }

    $id = (int) $id;

    if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
      $deactivation = $this->ion_auth->deactivate($id);
    }

    if ($deactivation) {
      $this->session->set_flashdata('message', "<div style='color:#00a65a'>" . $this->ion_auth->messages() . "</div>");
      redirect(site_url('admin/user_management'));
    }
  }

  // create a new user
	public function create_user()
  {

    $tables = $this->config->item('tables','ion_auth');
    $identity_column = $this->config->item('identity','ion_auth');
    $this->data['identity_column'] = $identity_column;

    // validate form input
    $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
    $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
    if($identity_column!=='email')
    {
        $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
    }
    else
    {
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
    }
    $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim|required');
    $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim|required');
    $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
    $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

    if ($this->form_validation->run() == true)
    {
        $email    = strtolower($this->input->post('email'));
        $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
        $password = $this->input->post('password');

        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name'  => $this->input->post('last_name'),
            'company'    => $this->input->post('company'),
            'phone'      => $this->input->post('phone'),
        );
    }
    if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
    {
        // check to see if we are creating the user
        // redirect them back to the admin page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect("admin/user_management", 'refresh');
    }
    else
    {
        // display the create user form
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name'),
            'class' => 'form-control',
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name'),
            'class' => 'form-control',
        );
        $this->data['identity'] = array(
            'name'  => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('identity'),
            'class' => 'form-control',
        );
        $this->data['email'] = array(
            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('email'),
            'class' => 'form-control',
        );
        $this->data['company'] = array(
            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('company'),
            'class' => 'form-control',
        );
        $this->data['phone'] = array(
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone'),
            'class' => 'form-control',
        );
        $this->data['password'] = array(
            'name'  => 'password',
            'id'    => 'password',
            'type'  => 'password',
            'value' => $this->form_validation->set_value('password'),
            'class' => 'form-control',
        );
        $this->data['password_confirm'] = array(
            'name'  => 'password_confirm',
            'id'    => 'password_confirm',
            'type'  => 'password',
            'value' => $this->form_validation->set_value('password_confirm'),
            'class' => 'form-control',
        );

      $this->activate_user_link();

      $this->template->set('title', 'Admin | User Management');
      $this->template->load('admin/templates/user_management', 'admin/user_management/add', $this->data);
    }
  }

    // edit a user
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
			  show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('admin/user_management', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('admin/user_management', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
      'class' => 'form-control'
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
      'class' => 'form-control'
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
      'class' => 'form-control'
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
      'class' => 'form-control'
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
      'class' => 'form-control'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
      'class' => 'form-control'
		);

    $this->activate_user_link();

    $this->template->set('title', 'Admin | User Management');
		$this->template->load('admin/templates/user_management', 'admin/user_management/edit', $this->data);
  }

  // Delete user
  public function delete_user($id)
  {
    if (is_null($id)) {
        $this->session->set_flashdata('message', "<div style='color:#dd4b39;'>Data tidak ditemukan.</div>");
    } else {
        $this->ion_auth->delete_user($id);
        $this->session->set_flashdata('message', "<div style='color:#00a65a;'>" . $this->ion_auth->messages() . "</div>");
    }
    redirect(site_url('admin/user_management'));
  }

  public function groups()
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the login page
      redirect('auth/login', 'refresh');
    }
    elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
    {
      // redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }
    else
    {
      // set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $this->data['groups'] = $this->ion_auth->groups()->result();

      $this->activate_group_link();

      $this->template->set('title', 'Admin | Group Management');
      $this->template->load('admin/templates/user_management', 'admin/group_management/list', $this->data);
    }
  }

  // create a new group
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash|trim');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("admin/user_management/groups", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
        'class' => 'form-control'
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
        'class' => 'form-control'
			);

      $this->activate_group_link();

      $this->template->set('title', 'Admin | Group Management');
			$this->template->load('admin/templates/user_management', 'admin/group_management/add', $this->data);
		}
	}

  // edit a group
	public function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('admin/user_management/groups', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth/login', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash|trim');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("admin/user_management/groups", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
      'class' => 'form-control'
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
      'class' => 'form-control'
		);

    $this->activate_group_link();

    $this->template->set('title', 'Admin | Group Management');
    $this->template->load('admin/templates/user_management', 'admin/group_management/edit', $this->data);
	}

  public function delete_group($id)
  {
    if (is_null($id)) {
        $this->session->set_flashdata('message', "<div style='color:#dd4b39;'>Data tidak ditemukan.</div>");
    } else {
        $this->ion_auth->delete_group($id);
        $this->session->set_flashdata('message', "<div style='color:#00a65a;'>" . $this->ion_auth->messages() . "</div>");
    }
    redirect(site_url('admin/user_management/groups'));
  }

  public function _get_csrf_nonce()
  {
    $this->load->helper('string');
    $key   = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $this->session->set_flashdata('csrfkey', $key);
    $this->session->set_flashdata('csrfvalue', $value);

    return array($key => $value);
  }

  public function _valid_csrf_nonce()
  {
    $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
    if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }

  public function activate_user_link()
  {
    if (current_url()) {
      $this->data['user_link_active'] = 'active';
      $this->data['group_link_active'] = '';
    }
  }

  public function activate_group_link()
  {
    if (current_url()) {
      $this->data['user_link_active'] = '';
      $this->data['group_link_active'] = 'active';
    }
  }

}
