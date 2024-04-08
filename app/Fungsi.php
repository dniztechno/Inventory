<?php

/**
 *
 */

class Fungsi
{

    public static $type = [
        'varchar' => 'text',
        'text' => 'text',
        'json' => 'text',
        'longtext' => 'text',
        'int' => 'number',
        'decimal' => 'number',
        'tinyint' => 'number',
        'date' => 'date',
        'time' => 'time',
        'year' => 'year',
        'enum' => 'text',
    ];

    public static $hari = [
        1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu',

    ];
    public static $bulan = array(
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    );
    public static function hariini()
    {
        return date('d') . " " . Fungsi::$bulan[date('n')] . " " . date('Y');
    }

}
