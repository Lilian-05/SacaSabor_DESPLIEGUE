<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Categoria;
use App\Models\Chicharroneria;
use App\Models\Comentario;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->crearImagenes();

        $categorias = [
            ['nombre' => 'Chicharrones', 'icono' => '🌶️', 'descripcion' => 'El clásico chicharrón de cerdo'],
            ['nombre' => 'Platos', 'icono' => '🍛', 'descripcion' => 'Platos típicos completos'],
            ['nombre' => 'Sándwiches', 'icono' => '🥪', 'descripcion' => 'Sándwiches de chicharrón y más'],
            ['nombre' => 'Bebidas', 'icono' => '🥤', 'descripcion' => 'Refrescos, mocochinche, refrescos'],
            ['nombre' => 'Guarniciones', 'icono' => '🥔', 'descripcion' => 'Papas, mote, ensaladas'],
            ['nombre' => 'Entradas', 'icono' => '🍢', 'descripcion' => 'Picantes y entradas para abrir el apetito'],
            ['nombre' => 'Especialidades', 'icono' => '👨‍🍳', 'descripcion' => 'Platos especiales de la casa'],
            ['nombre' => 'Sopas', 'icono' => '🍲', 'descripcion' => 'Sopas y caldos tradicionales'],
            ['nombre' => 'Postres', 'icono' => '🍮', 'descripcion' => 'Dulces y postres caseros'],
            ['nombre' => 'Bebidas calientes', 'icono' => '☕', 'descripcion' => 'Api, café, té y chocolate'],
            ['nombre' => 'Promociones', 'icono' => '🔥', 'descripcion' => 'Ofertas especiales y combos'],
        ];

        foreach ($categorias as $c) {
            Categoria::create($c);
        }

        $admin = User::create([
            'name' => 'Administrador SacaSabor',
            'email' => 'admin@sacasabor.com',
            'password' => 'password',
            'rol' => 'administrador',
        ]);

        $clientes = [
            ['Carlos Mamani', 'carlos@cliente.com'],
            ['María Choque', 'maria@cliente.com'],
            ['José Quispe', 'jose@cliente.com'],
            ['Rosa Flores', 'rosa@cliente.com'],
            ['Diego Vargas', 'diego@cliente.com'],
            ['Lucía Rojas', 'lucia@cliente.com'],
        ];

        $userClientes = collect();
        foreach ($clientes as $i => $c) {
            $userClientes->push(User::create([
                'name' => $c[0],
                'email' => $c[1],
                'password' => 'password',
                'rol' => 'cliente',
            ]));
        }

        $chicharronerias = [
            [
                'propietario' => ['Juan Pérez', 'juan@propietario.com'],
                'nombre' => 'Chicharronería La Tradición',
                'descripcion' => 'La mejor chicharronería tradicional de Sacaba. Chicharrón crujiente preparado con la receta de la abuela desde hace más de 30 años.',
                'direccion' => 'Av. Gral. Pando, esquina Calle Cochabamba',
                'zona' => 'Centro',
                'referencia' => 'A dos cuadras de la plaza principal',
                'telefono' => '72234567',
                'destacado' => true,
                'latitud' => '-17.4032',
                'longitud' => '-66.0390',
                'productos' => [
                    ['Chicharrón tradicional', 'Porción de chicharrón de cerdo con mote, papas y ensalada', 35.00, 1, true],
                    ['Chicharrón con llajwa', 'Chicharrón acompañado de llajwa casera', 40.00, 1, true],
                    ['Chicharrón con tuétano', 'Chicharrón servido con tuétano y papas', 42.00, 1, true],
                    ['Costillitas de cerdo', 'Costillas fritas con papas y ensalada', 45.00, 1, true],
                    ['Plato paceño', 'Chicharrón con papas, mote, habas y queso', 45.00, 2, true],
                    ['Chicharrón con arroz', 'Chicharrón acompañado de arroz y ensalada', 38.00, 2, true],
                    ['Plato completo', 'Combinado de chicharrón, mote, papa, ensalada y huevo', 50.00, 2, true],
                    ['Sándwich de chicharrón', 'Pan artesanal con chicharrón, llajwa y verduras', 18.00, 3, true],
                    ['Sándwich de chicharrón y huevo', 'Chicharrón, huevo frito y llajwa', 22.00, 3, true],
                    ['Papas fritas', 'Porción de papas fritas crocantes', 10.00, 5, true],
                    ['Ensalada fresca', 'Ensalada de lechuga, tomate y cebolla', 8.00, 5, true],
                    ['Mote pelado', 'Porción de mote de maíz', 7.00, 5, true],
                    ['Picante de lengua', 'Lengua de res en salsa picante con papas', 38.00, 6, false],
                    ['Chicharrón apretado', 'La especialidad de la casa, chicharrón extra crujiente', 46.00, 7, true],
                    ['Fricasé', 'Plato boliviano de cerdo, mote y llajwa', 35.00, 8, false],
                    ['Sopa de maní', 'Sopa cremosa de maní con papas', 25.00, 8, true],
                    ['Mocochinche', 'Refresco tradicional a base de durazno', 8.00, 4, true],
                    ['Refresco de mocochinche con durazno', 'Mocochinche con trozos de durazno', 10.00, 4, true],
                    ['Suco natural', 'Jugo de naranja y papaya', 12.00, 4, true],
                    ['Gelatina de pata', 'Postre tradicional de pata de res', 10.00, 9, true],
                    ['Queso de cabra', 'Postre/entrada típico de la zona', 14.00, 9, true],
                    ['Api con pastel', 'Bebida caliente de maíz morado con pastel frito', 12.00, 10, true],
                    ['Café pasado', 'Café de olla bien cargado', 7.00, 10, true],
                ],
            ],
            [
                'propietario' => ['Ana Gutiérrez', 'ana@propietario.com'],
                'nombre' => 'Chicharronería El Buen Sabor',
                'descripcion' => 'Sabores que conquistan el paladar. Chicharrón de calidad con atención cordial y ambiente familiar.',
                'direccion' => 'Calle Sacaba N° 458',
                'zona' => 'Zona Villa Obrera',
                'referencia' => 'Frente a la cancha de fútbol',
                'telefono' => '73345678',
                'destacado' => true,
                'latitud' => '-17.4065',
                'longitud' => '-66.0430',
                'productos' => [
                    ['Chicharrón familiar', 'Grande para compartir hasta 4 personas', 80.00, 1, true],
                    ['Chicharrón individual', 'Porción individual con guarnición', 30.00, 1, true],
                    ['Chicharrón con arroz', 'Chicharrón acompañado de arroz y ensalada', 38.00, 2, true],
                    ['Chicharrón con fideo', 'Chicharrón acompañado de fideo fideo', 36.00, 2, true],
                    ['Pollo a la broaster', 'Pollo crocante con papas y ensalada', 40.00, 2, false],
                    ['Sándwich de chicharrón familiar', 'Doble sándwich para compartir', 30.00, 3, true],
                    ['Sándwich de cuerito', 'Sándwich de piel de cerdo frita', 19.00, 3, true],
                    ['Papas a la huancaína', 'Papas con salsa de queso', 12.00, 5, true],
                    ['Ensalada rusa', 'Ensalada de papas, zanahoria y arvejas', 11.00, 5, false],
                    ['Chicharrón de pollo', 'Variante de chicharrón hecho con pollo crocante', 34.00, 7, true],
                    ['Charque con mote', 'Charque de llama con mote y papa', 42.00, 7, false],
                    ['Sopa de quinoa', 'Sopa nutritiva de quinoa', 24.00, 8, true],
                    ['Chicha de maíz', 'Bebida tradicional fermentada', 10.00, 4, false],
                    ['Refresco de cola de mota', 'Refresco de frutas tropicales', 9.00, 4, true],
                    ['Arroz con leche', 'Postre clásico cremoso', 9.00, 9, true],
                    ['Chocolate caliente', 'Chocolate espeso de la casa', 10.00, 10, true],
                ],
            ],
            [
                'propietario' => ['Pedro Salazar', 'pedro@propietario.com'],
                'nombre' => 'Chicharronería El Rincón Criollo',
                'descripcion' => 'Un rincón con sabor boliviano. Chicharrón crocante y delicioso, el favorito de los fines de semana.',
                'direccion' => 'Av. Circunvalación km 2',
                'zona' => 'Zona Sud',
                'referencia' => 'Al lado del colegio Bolívar',
                'telefono' => '74456789',
                'destacado' => false,
                'latitud' => '-17.4100',
                'longitud' => '-66.0340',
                'productos' => [
                    ['Chicharrón surtido', 'Combinado de chicharrón con frituras mixtas', 50.00, 2, true],
                    ['Chicharrón al horno', 'Variante horneada con menos grasa', 42.00, 1, true],
                    ['Cuerito frito', 'Piel de cerdo frita crujiente', 22.00, 1, true],
                    ['Chicharrón con tostado', 'Chicharrón con tostado de maíz', 40.00, 2, true],
                    ['Plato criollo', 'Chicharrón, papa, mote y llajwa bien picante', 44.00, 2, true],
                    ['Sándwich mixto', 'Chicharrón y huevo en pan crocante', 20.00, 3, true],
                    ['Sándwich de chicharrón criollo', 'Con llajwa y lechuga fresca', 21.00, 3, true],
                    ['Papas rústicas', 'Papas con cáscara al horno', 10.00, 5, true],
                    ['Ensalada criolla', 'Ensalada con tomate, cebolla y perejil', 9.00, 5, true],
                    ['Ceviche de chicharrón', 'Entrada fresca de chicharrón en limón', 28.00, 6, false],
                    ['Lengua guisada', 'Lengua de res guisada con arroz', 36.00, 7, true],
                    ['Sopa de chuño', 'Caldo espeso de chuño y carne', 22.00, 8, true],
                    ['Refresco de linaza', 'Refrescante natural', 7.00, 4, true],
                    ['Refresco de carambola', 'Exótico refresco de carambola', 11.00, 4, false],
                    ['Fresco de guayaba', 'Refresco de guayaba dulce', 9.00, 4, true],
                    ['Buñuelos', 'Buñuelos fritos espolvoreados con azúcar', 8.00, 9, true],
                    ['Té de anís', 'Infusión caliente de anís', 6.00, 10, true],
                ],
            ],
            [
                'propietario' => ['Laura Mendoza', 'laura@propietario.com'],
                'nombre' => 'Chicharronería Sabor Sacabeño',
                'descripcion' => 'Orgullosamente sacabeños. Nuestro chicharrón rescata el sabor auténtico de nuestra tierra.',
                'direccion' => 'Calle Sucre, frente a la iglesia',
                'zona' => 'Centro',
                'referencia' => 'Frente a la plaza de armas',
                'telefono' => '75567890',
                'destacado' => true,
                'latitud' => '-17.4010',
                'longitud' => '-66.0410',
                'productos' => [
                    ['Chicharrón premium', 'Corte especial de cerdo, el más suave', 55.00, 1, true],
                    ['Chicharrón con mote', 'Chicharrón acompañado de mote pelado', 40.00, 2, true],
                    ['Chicharrón con papas al horno', 'Con papas horneadas en manteca de cerdo', 43.00, 2, true],
                    ['Milanesa de cerdo', 'Milanesa de cerdo con papas fritas', 38.00, 2, false],
                    ['Sándwich de chicharrón sacabeño', 'Con queso derretido y llajwa', 22.00, 3, true],
                    ['Sándwich caliente', 'Pan tostado con chicharrón y huevo', 23.00, 3, true],
                    ['Chicharrón en salsa', 'Chicharrón bañado en salsa criolla', 39.00, 7, true],
                    ['Chicharrón de chancho dorado', 'Crocante dorado perfecto', 41.00, 1, true],
                    ['Picante surtido', 'Mezcla de cerdo, pollo y salchicha picante', 46.00, 6, true],
                    ['Papas con queso', 'Papas acompañadas de queso', 12.00, 5, true],
                    ['Mote con habas', 'Mote y habas sancochadas', 11.00, 5, false],
                    ['Sopa de verduras', 'Sopa ligera con verduras de la zona', 20.00, 8, true],
                    ['Refresco de mocochinche', 'El tradicional, bien frío', 8.00, 4, true],
                    ['Refresco de mondongo', 'Refresco espumoso de hierbas', 10.00, 4, true],
                    ['Limonada natural', 'Limonada con hierbabuena', 10.00, 4, true],
                    ['Api con pastel', 'Bebida caliente de maíz morado', 12.00, 10, true],
                    ['Toffee de la casa', 'Dulce de leche artesanal', 8.00, 9, true],
                ],
            ],
            [
                'propietario' => ['Saúl Roca', 'saul@propietario.com'],
                'nombre' => 'Chicharronería La Deliciosa',
                'descripcion' => 'Delicioso de verdad. Chicharrón jugoso, salsa casera y una experiencia que querrás repetir.',
                'direccion' => 'Zona Huayllani, Calle Principal N° 12',
                'zona' => 'Huayllani',
                'referencia' => 'A media cuadra de la parada de micro',
                'telefono' => '76678901',
                'destacado' => false,
                'latitud' => '-17.4180',
                'longitud' => '-66.0300',
                'productos' => [
                    ['Chicharrón picante', 'Con ají de la casa bien cargado', 38.00, 1, true],
                    ['Chicharrón con yuca', 'Acompañado de yuca frita', 42.00, 2, true],
                    ['Chicharrón con plátano', 'Con plátano frito maduro', 40.00, 2, true],
                    ['Chicharrón en pezuña', 'Porción de pezuña frita', 33.00, 1, true],
                    ['Sándwich de chicharrón picante', 'Con ají rocoto', 21.00, 3, true],
                    ['Sándwich de cerdo', 'Cerdo desmechado en pan tostado', 24.00, 3, false],
                    ['Chicharrón plus', 'Porción doble de chicharrón', 48.00, 7, true],
                    ['Torrejas de arroz', 'Torrejas de arroz fritas', 9.00, 5, true],
                    ['Ensalada de repollo', 'Ensalada fresca de repollo y zanahoria', 8.00, 5, true],
                    ['Papas deliciosas', 'Papas sazonadas de la casa', 11.00, 5, true],
                    ['Caldo de cardan', 'Caldo espeso y picante', 24.00, 8, true],
                    ['Sopa de trigo', 'Sopa de trigo con carne y verduras', 22.00, 8, false],
                    ['Agua mineral', 'Botella de 600ml', 6.00, 4, true],
                    ['Refresco de granadilla', 'Refresco de granadilla con leche', 12.00, 4, true],
                    ['Refresco de naranja', 'Naranja natural exprimida', 10.00, 4, true],
                    ['Sopaipilla', 'Sopaipilla dulce', 6.00, 9, true],
                    ['Café con leche', 'Café suave con leche caliente', 8.00, 10, false],
                ],
            ],
            [
                'propietario' => ['Nelly Castro', 'nelly@propietario.com'],
                'nombre' => 'Chicharronería El Fogón de Sacaba',
                'descripcion' => 'Cocina a fuego de leña, sabor inigualable. El chicharrón como se hacía antes.',
                'direccion' => 'Av. Ecológica km 4',
                'zona' => 'Zona Norte',
                'referencia' => 'Parada de trufi "El Fogón"',
                'telefono' => '77789012',
                'destacado' => true,
                'latitud' => '-17.3950',
                'longitud' => '-66.0450',
                'productos' => [
                    ['Chicharrón a la leña', 'Cocinado en fogón de leña, 4 horas', 48.00, 1, false],
                    ['Chicharrón con papa', 'Servido con papa criolla', 36.00, 2, true],
                    ['Chicharrón con mote', 'Mote de maíz blanco', 38.00, 2, true],
                    ['Chicharrón de pato', 'Especialidad única, pato a la leña', 55.00, 1, false],
                    ['Sándwich doble', 'Doblete de chicharrón', 25.00, 3, true],
                    ['Sándwich de la casa', 'Chicharrón, queso y yuca', 26.00, 3, true],
                    ['Chicharrón ahumado', 'Ahumado en leña de eucalipto', 45.00, 7, true],
                    ['Lechón dorado', 'Lechón al horno bien dorado', 52.00, 7, false],
                    ['Papas con cáscara', 'Papas doradas con todo y piel', 10.00, 5, true],
                    ['Mote con chicharrón', 'Tradicional del fogón', 39.00, 5, true],
                    ['Ensalada de la huerta', 'Verduras frescas de huerta propia', 9.00, 5, true],
                    ['Sopa de moté con chicharrón', 'Caldo con mote y trozos de chicharrón', 26.00, 8, true],
                    ['Refresco de maíz', 'Refresco suave de maíz', 8.00, 4, true],
                    ['Refresco de tumbo', 'Refresco ácido de tumbo', 11.00, 4, false],
                    ['Mocochinche casero', 'Elaborado en el día', 9.00, 4, true],
                    ['Pastel de maíz', 'Postre de maíz con canela', 9.00, 9, true],
                    ['Chicha de la casa', 'Chicha espesa de maíz', 11.00, 4, false],
                    ['Tinto de coca', 'Infusión de hojas de coca', 7.00, 10, true],
                ],
            ],
            [
                'propietario' => ['Don Túnel', 'tunel@propietario.com'],
                'nombre' => 'El Túnel',
                'descripcion' => 'La chicharronería más tradicional de Sacaba. Platos generosos, escabeche casero, tostado con tocineta y las mejores bebidas artesanales: garapiña, refresco hervido y helados hechos en casa.',
                'direccion' => 'Av. Túnel, entrada a Sacaba',
                'zona' => 'Zona Túnel',
                'referencia' => 'Frente al túnel de acceso a Sacaba',
                'telefono' => '78890123',
                'destacado' => true,
                'color' => '#e11d48',
                'latitud' => '-17.4080',
                'longitud' => '-66.0427',
                'productos' => [
                    ['Chicharrón entero', 'Porción grande de chicharrón con mote, papas y ensalada. Servido entero para chuparse los dedos.', 45.00, 2, true],
                    ['Chicharrón medio', 'Porción mediana de chicharrón con guarnición. Perfecto para una sola persona.', 25.00, 2, true],
                    ['Escabeche entero', 'Escabeche casero de cerdo, porción entera con papas y ensalada.', 40.00, 2, true],
                    ['Escabeche medio', 'Escabeche de cerdo en porción media con guarnición.', 22.00, 2, true],
                    ['Tostado con tocineta', 'Delicioso tostado de maíz con tocineta crocante y queso.', 30.00, 2, true],
                    ['Plato mixto chicharrón y escabeche', 'Combinación de chicharrón y escabeche bien servido.', 48.00, 2, true],
                    ['Pique al Túnel', 'Pique especial de la casa con carne, papas y salsas.', 42.00, 2, false],
                    ['Chicharrón con tostado', 'Chicharrón acompañado de tostado de maíz.', 35.00, 2, true],
                    ['Garapiña', 'Bebida tradicional producida en la zona, dulce y fermentada.', 10.00, 4, true],
                    ['Refresco hervido', 'Refresco de frutas hervido, servido frío. Especialidad de la casa.', 9.00, 4, true],
                    ['Gaseosa', 'Gaseosa bien fría de 500ml.', 7.00, 4, true],
                    ['Gaseosa familiar', 'Gaseosa de 2 litros para compartir.', 15.00, 4, true],
                    ['Helado artesanal', 'Helado hecho en casa con fruta natural. Pregunta por los sabores del día.', 8.00, 4, true],
                    ['Helado artesanal mediano', 'Helado casero en vaso mediano con dos sabores.', 12.00, 4, true],
                    ['Tublito de garapiña', 'Garapiña al tubo, picante y dulce al gusto.', 13.00, 4, true],
                    ['Mocochinche', 'Refresco tradicional de durazno, bien frío.', 9.00, 4, true],
                    ['Combo chicharrón entero + garapiña', 'PROMOCIÓN: chicharrón entero con garapiña incluida.', 50.00, 11, true],
                    ['Combo escabeche medio + helado', 'PROMOCIÓN: escabeche medio con helado artesanal de regalo.', 28.00, 11, true],
                    ['Combo 2 chicharrones medios', 'PROMOCIÓN: dos chicharrones medios por el precio de uno y medio.', 40.00, 11, true],
                    ['Combo familiar (4 personas)', 'PROMOCIÓN: 4 chicharrones medios, guarnición y garapiña familiar.', 90.00, 11, true],
                ],
            ],
        ];

        $idProducto = 1;
        $idChichar = 0;

        foreach ($chicharronerias as $ch) {
            $propietario = User::create([
                'name' => $ch['propietario'][0],
                'email' => $ch['propietario'][1],
                'password' => 'password',
                'rol' => 'propietario',
                'telefono' => $ch['telefono'],
            ]);

            $idChichar++;

            $chicharroneria = Chicharroneria::create([
                'propietario_id' => $propietario->id,
                'nombre' => $ch['nombre'],
                'descripcion' => $ch['descripcion'],
                'direccion' => $ch['direccion'],
                'zona' => $ch['zona'],
                'referencia' => $ch['referencia'],
                'telefono' => $ch['telefono'],
                'foto' => "imagenes/chicharroneria-$idChichar.svg",
                'foto_portada' => "imagenes/chicharroneria-$idChichar.svg",
                'latitud' => $ch['latitud'],
                'longitud' => $ch['longitud'],
                'destacado' => $ch['destacado'],
                'color' => $ch['color'] ?? null,
                'activa' => true,
            ]);

            foreach ($ch['productos'] as $p) {
                Producto::create([
                    'chicharroneria_id' => $chicharroneria->id,
                    'categoria_id' => $p[3],
                    'nombre' => $p[0],
                    'descripcion' => $p[1],
                    'precio' => $p[2],
                    'foto' => "imagenes/producto-$idProducto.svg",
                    'disponible' => $p[4],
                ]);
                $idProducto++;
            }

            $comentarios = [
                ['Muy buena atención y excelente chicharrón.', 4],
                ['El mejor chicharrón que he probado en Sacaba. ¡Recomendado!', 5],
                ['Buen sabor, aunque un poco de cola el fin de semana.', 4],
            ];

            foreach ($comentarios as $i => $com) {
                $usuario = $userClientes[$i % $userClientes->count()];
                Comentario::create([
                    'usuario_id' => $usuario->id,
                    'chicharroneria_id' => $chicharroneria->id,
                    'contenido' => $com[0],
                ]);
                Calificacion::updateOrCreate(
                    ['usuario_id' => $usuario->id, 'chicharroneria_id' => $chicharroneria->id],
                    ['puntaje' => $com[1]]
                );
            }

            if ($chicharroneria->calificacionPromedio() < 4.5) {
                Calificacion::updateOrCreate(
                    ['usuario_id' => $userClientes[5]->id, 'chicharroneria_id' => $chicharroneria->id],
                    ['puntaje' => 5]
                );
            }
        }

        $this->command->info('Datos de SacaSabor creados correctamente.');
    }

    protected function crearImagenes(): void
    {
        $colores = ['#e74c3c', '#d35400', '#f39c12', '#c0392b', '#e84393', '#b33939'];

        for ($i = 1; $i <= 8; $i++) {
            $color = $colores[$i % count($colores)];
            $svg = $this->generarSvg($color, "Chicharronería " . $i);
            Storage::disk('public')->put("imagenes/chicharroneria-$i.svg", $svg);
        }

        for ($i = 1; $i <= 150; $i++) {
            $color = $colores[$i % count($colores)];
            $svg = $this->generarSvg($color, "Producto " . $i);
            Storage::disk('public')->put("imagenes/producto-$i.svg", $svg);
        }
    }

    protected function generarSvg(string $color, string $texto): string
    {
        $texto = htmlspecialchars($texto, ENT_QUOTES);
        return <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600">
          <defs>
            <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stop-color="{$color}"/>
              <stop offset="100%" stop-color="#2c3e50"/>
            </linearGradient>
          </defs>
          <rect width="800" height="600" fill="url(#g)"/>
          <text x="400" y="290" font-family="Arial, sans-serif" font-size="44" fill="#fff" text-anchor="middle" font-weight="bold">🌶️</text>
          <text x="400" y="360" font-family="Arial, sans-serif" font-size="36" fill="#fff" text-anchor="middle" font-weight="bold">{$texto}</text>
          <text x="400" y="400" font-family="Arial, sans-serif" font-size="20" fill="#f5f5f5" text-anchor="middle">SacaSabor · Sacaba</text>
        </svg>
        SVG;
    }
}
