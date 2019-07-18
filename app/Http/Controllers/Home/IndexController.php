<?php

namespace App\Http\Controllers\Home;

use App\Services\MemberService;
use extend\Pay\PayTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

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

    public function sendSms()
    {
        return '短信发送';
    }

    public function getFirstChar()
    {
        $simple = firstpinyin('泸州州工业');
        return $simple;
    }

    public function getOldDay()
    {
        $str = '"\"\""';
        $a = json_decode($str,true);
        var_dump($a);
        if (empty($a) || $a == "\"\"") echo '空';

//        $contact_number = '095-45454545';
//        if (!preg_match('/^((1[3-9][0-9]{9})|(([0-9]{3,4}-)?[0-9]{7,8}))$/',$contact_number)) {
//            echo '不合法';
//        }
//        date_default_timezone_set('PRC');// 设置中国时区
//        echo date('Y-m-d H:i:s',strtotime("-90 day")); // 90 天前的时间
    }

    public function setRedis()
    {
//        Redis::command('set',['test_1','honghongces']);
//        echo Redis::command('get',['test_1']);

        // 获取队列长度，并从右侧以此取出队列
//        $max = Redis::command('llen',['keylist']);
//        for ($i = 0; $i <= $max; $i ++) {
//            $value = Redis::command('rpop',['keylist']);
//            echo $value."\r\n";
//        }
        $max = Redis::command('llen',['user_info']);
        for ($i = 0; $i <= $max; $i ++) {
            $user_info = Redis::command('rpop', ['user_info']);
            echo $user_info."\r\n";
        }
    }

    public function userInfo(Request $request,$id)
    {
//        print_r($request->all());
//        echo $id."\r\n";
//        echo ($request->url())."\r\n"; // 返回不带有查询字符串的 URL
//        echo ($request->fullUrl())."\r\n"; // 返回值包含查询字符串
//        echo ($request->path())."\r\n"; // 返回请求的路径信息
//        echo ($request->query('id'))."\r\n";
//        echo ($request->id)."\r\n";
//        return [1, 2, 3];

//        Redis::command('setex',['test_1',60,'test_1']); // 设置具体有效期的缓存
//        Redis::command('set',['test_2','test_2']);
//        echo Redis::command('TTL',['test_2']); // 获取过期时间

        // 从左侧写入队列
        for ($i = 0; $i <= 10; $i ++) {
            Redis::command('lpush',['keylist',$i]);
        }
    }

    public function setNxTest($id = 1)
    {
        $is_lock = Redis::command('setnx',['lock_key'.$id,1]); // 加锁
        if ($is_lock) {
            Redis::command('lpush',['user_info',$id]);
            Redis::command('del',['lock_key'.$id]);
        } else {
            // 如果并发的其他php进程，获取到lock_key的过期时间为-1，则设置lock_key过期时间5秒，避免死锁
            if (Redis::command('TTL',['lock_key'.$id]) == -1) {
                Redis::command('expire',['lock_key'.$id, 5]);
            }
            return "等到。。。。\r\n";
        }
    }

    public function getReferer()
    {
//        echo "<pre>";
//        print_r($_SERVER);
        $referer = $_SERVER['APP_URL'];
        $url = "http://huanguanjia.test";
        if ($url != $referer) echo '不匹配';
    }
}
