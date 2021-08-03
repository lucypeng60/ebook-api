<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
  public function me() {
    return ['NIS' => 3103119102,
        'name' => 'Lucy Aprilianda Putri Peng',
        'gender' => 'Female',
        'phone' => '08980600403',
        'class' => 'XII RPL 3'];
  }
}
