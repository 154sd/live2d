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
isset($_GET['id']) ? $id = $_GET['id'] : exit('error');

require '../tools/modelList.php';
require '../tools/modelTextures.php';
require '../tools/jsonCompatible.php';

$modelList = new modelList();
$modelTextures = new modelTextures();
$jsonCompatible = new jsonCompatible();

$id = explode('-', $id);
$modelId = (int)$id[0];
$modelTexturesId = isset($id[1]) ? (int)$id[1] : false;

$modelName = $modelList->id_to_name($modelId);
$modelTexturesList = is_array($modelName) ? array('textures' => $modelName) : $modelTextures->get_list($modelName);


if (count($modelTexturesList['textures']) <= 1) {
    $modelTexturesNewId = 1;
} else {
    $modelTexturesGenNewId = true;
    if ($modelTexturesId == 0) $modelTexturesId = 1;
    while ($modelTexturesGenNewId) {
        $modelTexturesNewId = rand(0, count($modelTexturesList['textures'])-1)+1;
        $modelTexturesGenNewId = $modelTexturesNewId == $modelTexturesId ? true : false;
    }
}

header("Content-type: application/json");
echo $jsonCompatible->json_encode(array('textures' => array(
    'id' => $modelTexturesNewId,
    'name' => $modelTexturesList['textures'][$modelTexturesNewId-1],
    'model' => is_array($modelName) ? $modelName[$modelTexturesNewId-1] : $modelName
)));
