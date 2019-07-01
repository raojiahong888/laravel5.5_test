<?php

namespace App\Http\Controllers\Home;

use extend\Pay\PayTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //调用第三方类库PayTest.php
    public function index()
    {
        $pay_obj = new PayTest();
        $res = $pay_obj->index();
        echo $res;
    }
}
