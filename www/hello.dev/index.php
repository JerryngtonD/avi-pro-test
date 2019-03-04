<?php
$url_info = parse_url($_SERVER['REQUEST_URI']);

function getValueOnId($query)
{
    parse_str($query, $output);

    $required_length = $output['length'];
    $output_value = md5($output['id']);

    if ($output['type'] == 'string') {
        $output_value = strtolower(preg_replace('/[0-9_\/]+/', '', base64_encode(sha1($output[id]))));
    } elseif ($output['type'] == 'digit') {
        $output_value = crc32($output[id]);
    }

    if (empty($output['length']) or !is_numeric($required_length)) {
        return $output_value;
    } elseif (is_numeric($required_length)) {
        return mb_strimwidth($output_value, 0, $required_length);
    }
}

function getIdOnQuery($query)
{
    parse_str($query, $output);
    return $output['id'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>
<body>
  <div class="wrapper">
    <h2>Сгенерируй свой id:</h2>
    <form action="/api/generate/" method="post">
      <p><input type="submit" value="сгенери id"/></p>
    </form>

    <?php if ($url_info['path'] == '/api/generate/'):?>
      <h3>
        Твой уникальный id: <?=uniqid();?>
      </h3>

    <?php elseif ($url_info['path'] == '/api/retrieve' and isset($url_info['query']) and getIdOnQuery($url_info['query']) != null) :?>
      <h3> Твой уникальный id:</h3> <?= getIdOnQuery($url_info['query'])?>
      <h3> Значение по id:</h3> <?= getValueOnId($url_info['query'])?>
    <?php endif;?>
</div>
</body>
</html>
