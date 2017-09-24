<?php
/**
 * @package DeskIgniter
 * @author: PeruCoder Dev Team
 * @Copyright (c) 2017, PeruCoder Dev Team - All rights reserved
 * @link http://deskigniter.com
 */

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_Client();
    }

    public function login()
    {
        $this->load->view('client/login');
    }
}