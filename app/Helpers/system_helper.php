<?php


if (!function_exists('set_header_message')) {
    function set_header_message($tipe, $title, $message)
    {
        session()->setFlashdata('message_header', array(
            'tipe' => $tipe,
            'title' => $title,
            'message' => $message,
        ));
    }
}



if (!function_exists('date_month_name')) {
    function date_month_name($bulan)
    {
        $mons = array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

        $ft = strtr($bulan, $mons);
        return $ft;
    }
}
