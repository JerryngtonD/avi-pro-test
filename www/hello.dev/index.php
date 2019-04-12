<?php
  include_once(__DIR__ . '/Store.php');
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>
<body>
  <div class="wrapper">
    <h2>Сгенерируй свой id:</h2>
    <form action="/api/generate/" method="post">
      <div>
        <h3>Выберите тип id:</h3>
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
        <h3>Выберите длину id:</h3>
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

    <?php
      echo $_SESSION['router']->handleGetId();
      echo $_SESSION['router']->handleGetValueOnId();
    ?>
    
</div>
</body>
</html>
