<?php
$url_info = parse_url($_SERVER['REQUEST_URI']);

function getGUID()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid, 12, 4)
            .substr($charid, 16, 4)
            .substr($charid, 20, 12);

        return $uuid;
    }
}

function getIdOnQuery()
{
    $required_type = $_POST['type'];
    $required_length = $_POST['length'];
    $output_value = uniqid();

    if ($required_type == 'string') {
        $output_value = strtolower(preg_replace('/[0-9_\/]+/', '', base64_encode(sha1($output[id]))));
    } elseif ($required_type == 'digit') {
        $output_value = crc32($output_value);
    } elseif ($required_type == 'guid') {
        $output_value = getGUID();
    }

    if (empty($required_length) or !is_numeric($required_length)) {
        return $output_value;
    } elseif (is_numeric($required_length)) {
        return mb_strimwidth($output_value, 0, $required_length);
    }
}

function getValueOnId($id)
{
    return sha1($id);
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
      <div>
        <h3>Выерите тип id:</h3>
        <input type="radio" id="string"
         name="type" value="string">
        <label for="string">строка</label>

        <input type="radio" id="digit"
         name="type" value="digit">
        <label for="digit">цифры</label>

        <input type="radio" id="guid"
         name="type" value="guid">
        <label for="guid">guid</label>

        <input type="radio" id="mixed"
         name="type" value="mixed">
        <label for="mixed">цифры-буквы</label>
      </div>
      <div>
        <h3>Выерите длину id:</h3>
        <input type="radio" id="short"
         name="length" value="5">
        <label for="short">5 символов</label>

        <input type="radio" id="medium"
         name="length" value="10">
        <label for="medium">10 символов</label>

        <input type="radio" id="huge"
         name="length" value="16">
        <label for="huge">16 символов</label>
      </div>
      <p>
        <input type="submit" value="получить id"/>
      </p>
    </form>

    <?php if ($url_info['path'] == '/api/generate/'):?>
      <h3>
        Твой уникальный id: <?= getIdOnQuery()?>
      </h3>

    <?php elseif ($url_info['path'] == '/api/retrieve' and isset($url_info['query']) and !empty($_GET['id'])) :?>
      <?php $sesion_id = $_GET['id']; ?>
      <h3> Твой уникальный id:</h3><?= $sesion_id ?>
      <h3> Значение по id:</h3> <?= getValueOnId($sesion_id)?>
    <?php endif;?>
</div>
</body>
</html>
