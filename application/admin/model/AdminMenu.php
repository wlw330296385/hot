<?php
namespace app\admin\model;
use think\Model;
use util\Tree;
use app\admin\model\AdminGroup;
use think\Exception;
class AdminMenu extends Model {

	// 设置当前模型对应的完整数据表名称
    protected $table = '__ADMIN_MENU__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 将节点url转为小写
    public function setUrlValueAttr($value)
    {
        return strtolower(trim($value));
    }


    /**
     * 获取指定节点ID的位置
     * @param string $id 节点id，如果没有指定，则取当前节点id
     * @param bool $del_last_url 是否删除最后一个节点的url地址
     * @param bool $check 检查节点是否存在，不存在则抛出错误
     * @return array
     * @throws \think\Exception
     */
    public static function getLocation($id = '', $del_last_url = false, $check = true)
    {
        $model      = request()->module();
        $controller = request()->controller();
        $action     = request()->action();

        if ($id != '') {
            $cache_name = 'location_menu_'.$id;
        } else {
            $cache_name = 'location_'.$model.'_'.$controller.'_'.$action;
        }

        $location = cache($cache_name);
        if (!$location) {
            // $map['pid'] = ['<>', 0];
            $map['url_value'] = strtolower($model.'/'.trim(preg_replace("/[A-Z]/", "_\\0", $controller), "_").'/'.$action);

            // 当前操作对应的节点ID
            $curr_id  = $id == '' ? self::where($map)->value('id') : $id;

            // 获取节点ID是所有父级节点
            $location = Tree::getParents(self::column('id,pid,title,url_value'), $curr_id);

            if ($check && empty($location)) {
                throw new Exception('获取不到当前节点地址，可能未添加节点,请联系woo添加节点', 9001);
            }

            // 剔除最后一个节点url
            if ($del_last_url) {
                $location[count($location) - 1]['url_value'] = '';
            }

            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache($cache_name, $location);
            }
        }
        return $location;
    }


        /**
     * 获取侧栏节点
     * @param string $id 模块id
     * @param string $module 模块名
     * @param string $controller 控制器名
     * @return array|mixed
     */
    public static function getSidebarMenu($id = '', $module = 'admin', $controller = '')
    {
        // $module     = $module == '' ? request()->module() : $module;
        // $controller = $controller == '' ? request()->controller() : $controller;
        $cache_tag  = strtolower('_sidebar_menus_'.session('admin.id'));
        // dump($cache_tag);
        $menus      = cache($cache_tag);
        // dump($menus);
        if (!$menus) {
            // 获取当前节点地址
            $location = self::getLocation($id);
            // 当前顶级节点id
            $top_id = $location[0]['id'];
            // 获取顶级节点下的所有节点
            $map = [
                'status' => 1,
                'module' => $module
            ];
            // 非开发模式，只显示可以显示的菜单
            if (config('develop_mode') == 0) {
                $map['online_hide'] = 1;
            }
            $map['online_hide'] = 1;
            // dump($map);
            $menus = self::where($map)->order('sort,id')->column('id,pid,module,title,url_value,url_type,url_target,icon');
            // dump($menus);
            // 解析模块链接
            if(config('develop_mode') == 0){
                foreach ($menus as $key => &$menu) {
                    // 没有访问权限的节点不显示
                    if (!AdminGroup::checkAuth($menu['id'])) {
                        unset($menus[$key]);
                        continue;
                    }
                }
            }
            $menus = self::toLayer($menus);
            // dump($menus);
            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache($cache_tag, $menus);
            }
        }
        return $menus;
    }



    public static function toLayer($arr = [],$pid = 0){
        $list = [];
         foreach ($arr as $key => $value) {
            if($value['pid'] == $pid){
                $value['daughter'] = self::toLayer($arr,$value['id']);
               $list[] = $value;
            }
        }
        return $list;
    }
}