<?php
function searchTrans($dir, $result = array()) {
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        $ndir = $dir.DIRECTORY_SEPARATOR.$value;
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($ndir)) {
                $result = searchTrans($ndir, $result);
            } else {
                $pathinfo = pathinfo($ndir);
                if (($pathinfo['extension'] == 'twig' &&
                    preg_match_all('/\{\{(.*?\|trans.*?)\}\}/', file_get_contents($ndir), $matches) !== false &&
                    count($matches[1]) > 0) ||
                    ($pathinfo['extension'] == 'php' &&
                    preg_match_all('/->trans\((.*?)\)/', file_get_contents($ndir), $matches) !== false &&
                    count($matches[1]) > 0)) {
                    $values = array_combine(array_values($matches[1]), array_fill(0, count($matches[1]), ''));
                    $result = array_merge($result, $values);
                }
            }
        }
    }

    return $result;
}
$value = searchTrans('../vendor/itkg');
ksort($value);
print_r($value);
?>