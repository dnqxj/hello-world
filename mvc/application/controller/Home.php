<?php
APP_PATH or exit('access denied');
require_once 'Base.php';
class Home extends Base
{
    public function index()
    {
        //如何加载html代码
//        require_once DEFAULT_PATH . '/application/view/index.php';
        //动态设置html的标题
        $title = '球是百科';
        FrameWork::view('index.php', $title);  //实参
        FrameWork::view('hello.html', $title);
    }

    //助手函数
    public function helps()
    {
        $arr = array('id'=>1,'username'=>'admin','password'=>'123456','age'=>18,'info'=>array('addr'=>'安徽合肥'));
//        halt($arr);
        print_r(get());
    }

    public function db(){
        //访问mysql
/*        $where['id'] = 1;
        $where['username'] = 'he';
        $res = Db::item('admins', $where);*/
/*        $where['id>0'] = null;
        $res = Db::lists('admins',$where, 'id desc');*/

        //自定义列表索引
        //user[用户表]
        /*$user_list = array(
            0=>array('uid'=>1,'gid'=>1,'username'=>'张三'),
            1=>array('uid'=>2,'gid'=>2,'username'=>'李四'),
            2=>array('uid'=>3,'gid'=>2,'username'=>'王五'),
        );

        //group[用户角色]
        $group_list = array(
            0=>array('gid'=>1,'title'=>'VIP'),
            1=>array('gid'=>2,'title'=>'VIP高级用户'),
            2=>array('gid'=>3,'title'=>'钻石'),
        );
        $result = array();
        foreach ($group_list as $key=>$item) {
            $result[$item['gid']] = $item;
        }
        halt($result);

        foreach($user_list as $key=>$item){
            $group_name = isset($group_list[$item['gid']])?$group_list[$item['gid']]['title']:'';
            $user_list[$key]['group_name'] = $group_name;
        }
        dump($user_list);
        echo '<hr>';*/
       /* $where['id>0'] = null;
        $count = Db::totals('admins',$where);*/

       //分页
        /*$where['id>0'] = null;
        $page = 1;
        $num = 10;
        $res = Db::pagination('admins', $where,$page,$num);*/

        //添加数据
        /*$table = 'admins';
        $data['username'] = 'yanglang';
        $data['password'] = 'dasfdsjaf';
        $res = Db::insert($table, $data);*/
        $db = new Sysdb;
        $res = $db->table('admins')->where(['id'=>1])->item();
        dump($res);
    }
}
