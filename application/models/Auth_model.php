<?php
class Auth_model extends CI_Model
{
    public function logout($date, $email)
    {
        $this->db->where($this->email, $email);
        $this->db->update($this->last_login, $date);
    }
}
