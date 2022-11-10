<fieldset>
    <legend>Informacion General</legend>

    <label for="titulo">Titulo:</label>
    <input type="text" name="entrada[titulo]" id="titulo" placeholder="Titulo entrada" value="<?php echo s($entrada->titulo); ?>">

    <label for="autor">Autor:</label>
    <input type="text" name="entrada[autor]" id="autor" placeholder="Autor entrada" value="<?php echo s($entrada->autor); ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="entrada[imagen]">

    <?php if($entrada->imagen):  ?>
        <img src="/imagenes_entradas/<?php echo $entrada->imagen?>" alt="" class="imagen-small">

    <?php endif; ?>

    <label for="descripcion">Descripcion:</label>
    <textarea name="entrada[descripcion]" id="descripcion"><?php echo s($entrada->descripcion); ?></textarea>
</fieldset>