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
$config['length_login_ticket'] = 70;
$config['length_authorization_token'] = 70;


/**
 * Validity duration of login tickets
 *
 * The values are in secondes
 *
 * The more smaller the values are the more secure the system is
 *
 * !! WARNING !! Too small values could make the system unusuable
 *
 * duration_pending_tickets : The duration of the pending tickets
 * duration_validated_tickets : The duration of the validated ticket
 * (that have a user associated with to the ticket)
 */
$config['duration_pending_tickets'] = 600; //15 minutes
$config['duration_validated_tickets'] = 60; //1 minute