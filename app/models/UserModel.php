<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: UserModel
 *
 * Handles user-related database operations for login and registration.
 */
class UserModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if user exists by email or username for login.
     */
    public function get_user_by_email_or_username($identifier)
    {
        try {
            return $this->db->table('users')
                            ->where('email', $identifier)
                            ->or_where('username', $identifier)
                            ->get();
        } catch (Exception $e) {
            // Fallback to raw query if prepared statement fails
            return $this->db->raw("SELECT * FROM users WHERE email = ? OR username = ?", [$identifier, $identifier])->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Check if email exists.
     */
    public function email_exists($email)
    {
        try {
            $result = $this->db->table('users')->where('email', $email)->get();
            return !empty($result);
        } catch (Exception $e) {
            // Fallback to raw query
            $result = $this->db->raw("SELECT * FROM users WHERE email = ?", [$email])->fetch(PDO::FETCH_ASSOC);
            return !empty($result);
        }
    }

    /**
     * Check if username exists.
     */
    public function username_exists($username)
    {
        try {
            $result = $this->db->table('users')->where('username', $username)->get();
            return !empty($result);
        } catch (Exception $e) {
            // Fallback to raw query
            $result = $this->db->raw("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_ASSOC);
            return !empty($result);
        }
    }

    /**
     * Create a new user.
     */
    public function create_user($data)
    {
        return $this->db->table('users')->insert($data);
    }

    /**
     * Get user by ID.
     */
    public function get_user_by_id($id)
    {
        return $this->db->table('users')->where('id', $id)->get();
    }

    /**
     * Check if user has a student record by email.
     */
    public function has_student_record($email)
    {
        $result = $this->db->table('students')->where('email', $email)->get();
        return !empty($result);
    }
}
?>
