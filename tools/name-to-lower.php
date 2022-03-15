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
      /* 批量转换 文件名为 小写英文 + 使用 连字符-替换-空格 */
$path = '../model/test-path';//<--- 在此输入目录路径，并执行本面页


/*-----------------------------------------------------------------*/
                $path = str_replace('\\', '/', $path);
          if (substr($path, -1) != '/') $path = $path . '/';
/*-----------------------------------------------------------------*/
foreach ( glob($path.'*') as $file ) {
    $new_filename = str_replace(' ', '-', strtolower($file));
    rename($file, $new_name); echo $file.' -> '.$new_name." ok. \n";
}
/*-----------------------------------------------------------------*/
