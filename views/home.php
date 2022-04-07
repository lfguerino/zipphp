<?php $v->layout("_theme"); ?>

<?php $v->start("styles"); ?>
<style>
    input {
        display: block;
        margin-bottom: 20px;
    }
</style>
<?php $v->end(); ?>

<h1>LFGuerino\ZipPHP</h1>
<form>
    <label>
        Nome do Diretório do Projeto
        <input name="dirProjectName" />
    </label>
    <label>
        Nome do Arquivo ZIP
        <input name="filename" />
        <button>Gerar Arquivo</button>
    </label>
</form>