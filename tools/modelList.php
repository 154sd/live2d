<?php 
$_ALLOW_ORIGIN = array(

          'http://127.0.0.1:8080'

      );

      $_ORIGIN = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

      if(in_array($_ORIGIN, $_ALLOW_ORIGIN)){undefined

          header('Access-Control-Allow-Origin:'.$_ORIGIN);

      }

      header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies

      header('Access-Control-Expose-Headers: *');

      header('Access-Control-Allow-Headers: *');

}
class modelList {
    // 准许跨域请求。

    /* 获取模型列表 */
    function get_list() {
        return json_decode(file_get_contents('../model_list.json'), 1);
    }
    
    /* 获取模组名称 */
    function id_to_name($id) {
        $list = self::get_list();
        return $list['models'][(int)$id-1];
    }
    
    /* 转换模型名称 */
    function name_to_id($name) {
        $list = self::get_list();
        $id = array_search($name, $list['models']);
        return is_numeric($id) ? $id + 1 : false;
    }
    
}
