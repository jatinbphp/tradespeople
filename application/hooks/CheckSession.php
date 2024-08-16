<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CheckSession
{
    public function sessionCheck()
    {
        $CI = &get_instance();

        // Check if the user is logged in
        if (!$CI->session->userdata('logged_in')) {
            // User is not logged in, update the flag
            if ($CI->session->userdata('user_id')) {
                $user_id = $CI->session->userdata('user_id');

                // Update the flag in the database
                $CI->db->where('id', $user_id);
                $CI->db->update('users', ['flag' => 0]);

                // Destroy the session
                $CI->session->sess_destroy();
            }
        }
    }
}