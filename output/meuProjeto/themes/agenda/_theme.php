<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- PRECONNECT FIRST -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- META TAGS -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fa296b00ec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= theme("assets/css/style.css") ?>">
    <title>Gerenciador de tarefas</title>
</head>

<body>
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Adicionando tarefa...</p>
        </div>
    </div>

    <?= $v->section("content"); ?>

    <script src="<?= theme("assets/js/jquery-3.6.0.min.js"); ?>"></script>
    <script src="<?= theme("assets/js/jquery.form.js"); ?>"></script>
    <!-- <script src="<?= theme("assets/js/script.js"); ?>"></script> -->
    <?= $v->section("scripts"); ?>
</body>

</html>