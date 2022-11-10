<main class="contenedor seccion contenido-centrado">
        <h1><?php echo $entrada->titulo; ?></h1>
        <picture>
            <img loading="lazy" src="/imagenes_entradas/<?php echo $entrada->imagen; ?>" alt="Imagen de la propiedad">
        </picture>

        <div>
            <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> 
            por: <span><?php echo $entrada->autor; ?></span></p>
            <p>
            <?php echo $entrada->descripcion; ?>
            </p>

        </div>

    </main>
