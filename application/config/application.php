<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application configuration
 *
 * @author Pierre HUBERT
 */

/**
 * Name of the auth system
 */
$config['app_name'] = "centralAuth";


/**
 * Length of the different tokens
 */
$config['length_login_ticket'] = 50;
$config['length_authorization_token'] = 50;