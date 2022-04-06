<?php $v->layout('_theme'); ?>

<div class="container">
    <h1>Agenda de Tarefas</h1>
    <hr>

    <form action=<?= url("/tarefa/adicionar") ?> method="post">
        <input id="inputTask" type="text" name="task" id="" placeholder="Quais são suas tarefas de hoje?" autofocus />
        <button id="addTask" type="submit">Adicionar</button>
    </form>

    <?php if (!empty($tasks)) : ?>
        <?php foreach ($tasks as $task) : ?>
            <li class='task <?= ($task->completed_at) ? 'taskCompleted' : '' ?>'><?= $task->title ?>
                <a title="Excluir tarefa" href="<?= url("/tarefa/remover/{$task->id}") ?>"><i class="fa fa-trash-alt agenda-icon"></i></a>
                <?php if (!$task->completed_at) : ?>
                    <a title="Completar tarefa" href="<?= url("/tarefa/completar/{$task->id}") ?>"><i class="far fa-circle agenda-icon"></i></a>
                <?php else : ?>
                    <a title="Desfazer" href="<?= url("/tarefa/desfazer/{$task->id}") ?>"><i class="far fa-check-circle agenda-icon"></i></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <button id="clearAllTasks">Deletar Tarefas</button>

    <?php else : ?>
        <span id="noTasks">Não há tarefas para serem exibidas</span>
    <?php endif; ?>
</div>

<?php $v->start('scripts'); ?>
<script>
    $('button#clearAllTasks').on('click', function() {
        if (confirm("Deseja realmente excluir todas as tarefas?")) {
            window.location = "<?= url("/tarefa/remover/todas") ?>"
        }
    })
</script>
<?php $v->end(); ?>