<?php
namespace App\Traits;

use Hekmatinasser\Verta\Verta;

trait HasShamsiDates
{
    public function getShamsiDateTime($date)
    {
        return Verta::instance($date)->format('Y/m/d H:i:s'); // فرمت دلخواه خود را اینجا مشخص کنید
    }
    public function getShamsiDate($date)
    {
        return Verta::instance($date)->format('Y/m/d'); // فرمت دلخواه خود را اینجا مشخص کنید
    }
}

