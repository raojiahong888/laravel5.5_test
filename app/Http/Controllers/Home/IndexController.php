<?php

namespace App\Http\Controllers\Home;

use App\Services\MemberService;
use extend\Pay\PayTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //调用第三方类库PayTest.php，对应的目录是extend/Pay/PayTest.php，该extend目录不是系统默认加载的目录，故需在composer.json文件配置该extend目录的自动加载项
    public function index()
    {
        $pay_obj = new PayTest();
        $res = $pay_obj->index();
        echo $res;
    }

    //app目录下新增的Services目录，不用额外配置，也可以调用Services目录下面所有的php文件
    public function memberInfo()
    {
        $member_service = new MemberService();
        $res = $member_service->memberInfo();
        return $res;
    }
}
