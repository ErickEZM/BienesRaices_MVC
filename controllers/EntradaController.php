<?php

namespace Controllers;
use MVC\Router;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as image;

class EntradaController {
    public static function crear(Router $router) {

        $errores = Entrada::getErrores();

        $entradas = new Entrada;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $entradas = new Entrada($_POST['entrada']);

            /* SUBIDA DE ARCHIVOS */
    
            // Genera un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
    
            // Setear la Imagen 
            // Realiza un resize a la imagen con intervation
            if($_FILES['entrada']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen']) -> fit(600,600);
                $entradas-> setImagen($nombreImagen);
            }
    
            // Validar 
            $errores = $entradas->validar();
    
            // Revisar que el arreglo de errores este vacio 
            if (empty($errores)) {
    
                // Crear la carpeta para subir imagenes 
                if(!is_dir(CARPETA_IMAGENES_ENTRADAS)){
                    mkdir(CARPETA_IMAGENES_ENTRADAS);
                }
    
                // Guarda la imagen en el servidor 
                $image -> save(CARPETA_IMAGENES_ENTRADAS . $nombreImagen);
    
                // Guarda en la Base de Datos
                $entradas -> guardar();
    
            }
        }

        $router->render('entradas/crear', [
            'entradas' => $entradas,
            'errores' => $errores


        ]);

    }

    public static function actualizar(Router $router) {

        $id = validarORedireccionar('/admin');
        $entrada = Entrada::find($id);
        $errores = Entrada::getErrores();

        // Ejecutar el codigo despues de que el usuario envie el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['entrada'];

            $entrada->sincronizar($args);

            // Validacion
            $errores = $entrada->validar();

            // Genera un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

            // Subida de archivos 
            if($_FILES['entrada']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['entrada']['tmp_name']['imagen']) -> fit(600,600);
                $entrada-> setImagen($nombreImagen);
            }

            // Revisar que el arreglo de errores este vacio 
            if (empty($errores)) {
                if($_FILES['entrada']['tmp_name']['imagen']) {
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES_ENTRADAS . $nombreImagen);
                }

                $resultado = $entrada->guardar();
            }
        }

        $router->render('entradas/actualizar' , [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
        
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
    
            if($id) {
    
                $tipo = $_POST['tipo'];
    
                if(validarTipoContenido($tipo)) {
                    $entrada = Entrada::find($id);
                    $entrada->eliminar();
                    
                } 
    
            }
    
        }

    }
}