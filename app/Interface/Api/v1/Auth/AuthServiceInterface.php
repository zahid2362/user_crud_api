<?php

namespace App;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function login(Request $request):array;
    public function registration(Request $request):array;
}