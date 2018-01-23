<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2013 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace app\common\taglib;
use think\template\TagLib;
defined('THINK_PATH') or exit();
/**
 * Html标签库驱动
 */
class Html extends TagLib{
    // 标签定义
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'editor'    => ['attr'=>'id,name,style,width,height,type','close'=>1],
       // 'select'    => ['attr'=>'name,options,values,output,multiple,id,size,first,change,selected,dblclick','close'=>0],
        'grid'      => ['attr'=>'id,pk,style,action,actionlist,show,datasource','close'=>0],
        //'list'      => ['attr'=>'id,pk,style,action,actionlist,show,datasource,checkbox','close'=>0],
        'imagebtn'  => ['attr'=>'id,name,value,type,style,click','close'=>0],
        //'checkbox'  => ['attr'=>'name,checkboxes,checked,separator','close'=>0],
        //'radio'     => ['attr'=>'name,radios,checked,separator','close'=>0],
    ];

    /**
     * editor标签解析 插入可视化编辑器
     * 格式： <html:editor id="editor" name="remark" type="FCKeditor" style="" >{$vo.remark}</html:editor>
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagEditor($tag,$content) {
        $id            =    !empty($tag['id'])?$tag['id']: '_editor';
        $name       =    $tag['name'];
        $style           =    !empty($tag['style'])?$tag['style']:'';
        $width        =    !empty($tag['width'])?$tag['width']: '100%';
        $height     =    !empty($tag['height'])?$tag['height'] :'320px';
     //   $content    =   $tag['content'];
        $type       =   $tag['type'] ;
        switch(strtoupper($type)) {
                case 'UEDITOR':
                $parseStr   =  "\n".'<script type="text/javascript" charset="utf-8" src="/static/UEditor/ueditor.config.js"></script>'."\n".'<script type="text/javascript" charset="utf-8" src="/static/UEditor/ueditor.all.js"></script>'."\n".'<script type="text/plain" id="'.$id.'" name="'.$name.'" style="'.$style.'">'.$content.'</script>'."\n".'<script type="text/javascript">var ue_'.$id.' = UE.getEditor("'.$id.'");</script>'."\n";
                break;
            default :
                $parseStr  =  '<textarea id="'.$id.'" style="'.$style.'" name="'.$name.'" >'.$content.'</textarea>';
        }
        return $parseStr;
    }

    /**
     * imageBtn标签解析
     * 格式： <html:imageBtn type="" value="" />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagImagebtn($tag) {
        $name       = $tag['name'];                //名称
        $value      = $tag['value'];                //文字
        $id         = isset($tag['id'])?$tag['id']:'';                //ID
        $style      = isset($tag['style'])?$tag['style']:'';                //样式名
        $click      = isset($tag['click'])?$tag['click']:'';                //点击
        $type       = empty($tag['type'])?'button':$tag['type'];                //按钮类型

        if(!empty($name)) {
            $parseStr   = '<div class="'.$style.'" ><input type="'.$type.'" id="'.$id.'" name="'.$name.'" value="'.$value.'" onclick="'.$click.'" class="'.$name.' imgButton"></div>';
        }else {
            $parseStr   = '<div class="'.$style.'" ><input type="'.$type.'" id="'.$id.'"  name="'.$name.'" value="'.$value.'" onclick="'.$click.'" class="button"></div>';
        }

        return $parseStr;
    }

    /**
     * imageLink标签解析
     * 格式： <html:imageLink type="" value="" />
     * @access public
     * @param array $tag 标签属性
     * @return string|void
     */
    public function tagImglink($tag) {
        $name       = $tag['name'];                //名称
        $alt        = $tag['alt'];                //文字
        $id         = $tag['id'];                //ID
        $style      = $tag['style'];                //样式名
        $click      = $tag['click'];                //点击
        $type       = $tag['type'];                //点击
        if(empty($type)) {
            $type = 'button';
        }
           $parseStr   = '<span class="'.$style.'" ><input title="'.$alt.'" type="'.$type.'" id="'.$id.'"  name="'.$name.'" onmouseover="this.style.filter=\'alpha(opacity=100)\'" onmouseout="this.style.filter=\'alpha(opacity=80)\'" onclick="'.$click.'" align="absmiddle" class="'.$name.' imgLink"></span>';

        return $parseStr;
    }
}