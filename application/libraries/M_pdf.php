<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Path to Composer autoload file inside third_party
require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';

class M_pdf {

    public function __construct() {
        // Optional: default configuration
    }

    public function load($params = []) {
        return new \Mpdf\Mpdf($params);
    }
}
