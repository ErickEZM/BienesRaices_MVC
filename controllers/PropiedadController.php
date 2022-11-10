<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Model\Entrada;
use Intervention\Image\ImageManagerStatic as image;


class PropiedadController {

    public static function index(Router $router) {

        $propiedades = Propiedad::all();

        $vendedores = Vendedor::all();

        $entradas = Entrada::all();

        
        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin' , [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores,
            'entradas' => $entradas
        ]);
        
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            /* Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);
    
    
            /* SUBIDA DE ARCHIVOS */
    
            // Genera un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
    
            // Setear la Imagen 
            // Realiza un resize a la imagen con intervation
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen']) -> fit(600,600);
                $propiedad-> setImagen($nombreImagen);
            }
    
            // Validar 
            $errores = $propiedad->validar();
    
            // Revisar que el arreglo de errores este vacio 
            if (empty($errores)) {
    
                // Crear la carpeta para subir imagenes 
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
    
                // Guarda la imagen en el servidor 
                $image -> save(CARPETA_IMAGENES . $nombreImagen);
    
                // Guarda en la Base de Datos
                $propiedad -> guardar();

    
            }
        }

        
        $router-> render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores

        ]);
        
    }

    public static function actualizar(Router $router) {
        
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        // Ejecutar el codigo despues de que el usuario envie el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            // Validacion
            $errores = $propiedad->validar();

            // Genera un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';

            // Subida de archivos 
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen']) -> fit(600,600);
                $propiedad-> setImagen($nombreImagen);
            }

            // Revisar que el arreglo de errores este vacio 
            if (empty($errores)) {
                if($_FILES['propiedad']['tmp_name']['imagen']) {
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $resultado = $propiedad->guardar();
            }
        }

        $router->render('/propiedades/actualizar' , [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
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
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                    
                } 
    
            }
    
        }

    }

}