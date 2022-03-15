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
isset($_GET['id']) ? $modelId = (int)$_GET['id'] : exit('error');

require '../tools/modelList.php';
require '../tools/jsonCompatible.php';

$modelList = new modelList();
$jsonCompatible = new jsonCompatible();

$modelList = $modelList->get_list();

$modelRandNewId = true;
while ($modelRandNewId) {
    $modelRandId = rand(0, count($modelList['models'])-1)+1;
    $modelRandNewId = $modelRandId == $modelId ? true : false;
}


header("Content-type: application/json");
echo $jsonCompatible->json_encode(array('model' => array(
    'id' => $modelRandId,
    'name' => $modelList['models'][$modelRandId-1],
    'message' => $modelList['messages'][$modelRandId-1]
)));
