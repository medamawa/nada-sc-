<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessKey extends Model
{
    public function codeIsOk(String $code)
    {
        return (Boolean) $this->where('student_code', $code)->first();
    }

    public function passIsOk(String $code, String $pass)
    {
        $data = $this->where('student_code', $code)->first();

        return $data->access_password == $pass;
    }

    public function getData(String $code)
    {
        return $this->where('student_code', $code)->first();
    }
}
