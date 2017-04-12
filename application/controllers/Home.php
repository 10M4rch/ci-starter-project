<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    // Load dashboard
    $this->template->set('title', 'Dashboard');
    $this->template->load('templates/dashboard', 'dashboard');
  }

  public function datatable()
  {
    // Load sample datatable and form
    $this->template->set('title', 'Datatable');
    $this->template->load('templates/datatable', 'datatable');
  }

  public function blank()
  {
    $this->template->set('title', 'Blank Page');
    $this->template->load('templates/blank_page', 'blank_page');
  }

  public function user()
  {
    $this->template->set('title', 'Profile');
    $this->template->load('templates/profile', 'profile');
  }

}
