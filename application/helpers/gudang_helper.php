<?php
function is_logged_in() //ini untuk mengecek apakah user sudah login atau belum
{
    $ci = get_instance();
    $ci->session->userdata('email') || redirect('auth');
}

function is_admin()
{
    $ci = get_instance();
    $role = $ci->session->get_userdata('login_session')['role'];

    $status  = true;

    if ($role != 'admin') {
        $status = false;
    }

    return $status;
}

function userdata($field)
{
    $ci = get_instance();
    $ci->load->model('Admin_model', 'admin');

    $userId = $ci->session->userdata('login_session')['user'];
    return $ci->admin->get('user', ['id' => $userId])[$field];
}

function set_pesan($message, $tipe = true) //ini untuk menampilkan message
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Selamat!</strong> ' . $message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>');
    } else {
        $ci->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Maaf!</strong> ' . $message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>');
    }
}

function output_json($data) //ini untuk mengubah data menjadi json
{
    $ci = get_instance();
    $ci->output->set_content_type('application/json')->set_output(json_encode($data));
}

if (!function_exists('setting')) {
    function setting($column_name)
    {
        $CI = &get_instance();
        $CI->load->library('Other_model');

        $managements = $CI->Other_model->getSetting();

        return isset($managements[$column_name]) ? $managements[$column_name] : '';
    }
}
