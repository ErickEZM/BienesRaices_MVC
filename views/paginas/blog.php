<main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

    <article class="entrada-blog">
        <?php foreach($entradas as $entrada):  ?>
        <div class="entrada">
                <img loading="lazy" src="/imagenes_entradas/<?php echo $entrada->imagen; ?>" alt="Texto Entrada Blog" class="separacion-imagenes imagen-entrada">
        </div>

        <div class="texto-entrada">
            <a href="/entrada?id=<?php echo $entrada->id; ?>">
                <h4><?php echo $entrada->titulo; ?></h4>
                    <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span><?php echo $entrada->autor; ?></span></p>
                    <p><?php echo $entrada->descripcion; ?>
                    </p>
            </a>

        </div>
        <?php endforeach; ?>
    </article>


</main>