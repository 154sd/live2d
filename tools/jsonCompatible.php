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
class jsonCompatible {
    public function json_encode($json) {
        if (version_compare(PHP_VERSION,'5.4.0','<')) {
            $json = json_encode($json);
            $json = str_replace('\/', '/', $json);
            $json = preg_replace_callback("/\\\u([0-9a-f]{4})/i", array($this,'json_preg_replace'), $json);
            return $this->json_pretty_print($json, '    ');
        } else return json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function json_preg_replace($matchs) {
        return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
    }
    
    protected function json_pretty_print($json, $indent = "\t") {
        $result = '';
        $indentCount = 0;
        $inString = false;
        $len = strlen($json);
        for ($c = 0; $c < $len; $c++) {
            $char = $json[$c];
            if ($char === '{' || $char === '[') {
                if (!$inString) {
                    $indentCount++;
                    if ($char === '[' && $json[$c+1]  == "]") $result .= $char . PHP_EOL;
                    elseif ($char === '{' && $json[$c+1]  == "}") $result .= $char . PHP_EOL;
                    else $result .= $char . PHP_EOL . str_repeat($indent, $indentCount);
                } else $result .= $char;
            } elseif ($char === '}' || $char === ']') {
                if (!$inString) {
                    $indentCount--;
                    $result .= PHP_EOL . str_repeat($indent, $indentCount) . $char;
                } else $result .= $char;
            } elseif ($char === ',') {
                if (!$inString) $result .= ',' . PHP_EOL . str_repeat($indent, $indentCount);
                else $result .= $char;
            } elseif ($char === ':') {
                if (!$inString) $result .= ': ';
                else $result .= $char;
            } elseif ($char === '"') {
                if (($c > 0 && $json[$c - 1] !== '\\') || ($c > 1 && $json[$c - 2].$json[$c - 1] === '\\\\')) $inString = !$inString;
                $result .= $char;
            } else {
                $result .= $char;
            }
        }
        return $result;
    }
}
