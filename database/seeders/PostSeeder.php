<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $authorId = User::where('email', 'admin@multiverse-comics.com')->value('id')
            ?? User::factory()->create([
                'name' => 'Multiverse Editor',
                'email' => 'editor@multiverse-comics.com',
                'password' => bcrypt('editor123'),
            ])->id;

        $posts = [
            [
                'title' => 'Lo que necesitas saber antes de Avengers: Secret Wars',
                'category' => 'Noticias',
                'cover_image' => '/images/posts/comics.jpg',
                'excerpt' => 'Repasamos los eventos clave del multiverso Marvel que preparan el terreno para la próxima gran saga cinematográfica.',
                'content' => <<<HTML
<p>El multiverso Marvel continúa expandiéndose y todo apunta a que <strong>Secret Wars</strong> será el evento que sacudirá a los héroes y villanos por igual. En Multiverse Comics analizamos los cómics esenciales para comprender la escala del conflicto y cómo nuestras ediciones especiales te ayudarán a sumergirte en la acción.</p>
<p>Desde los clásicos de Jonathan Hickman hasta las nuevas historias de <em>Kang el Conquistador</em>, tenemos guías, ediciones coleccionistas y bundles exclusivos para que no te pierdas ningún detalle.</p>
HTML,
                'is_featured' => true,
                'published_at' => $now->copy()->subDays(6),
            ],
            [
                'title' => '3 historias de Batman que redefinen a Gotham',
                'category' => 'Blog',
                'cover_image' => '/images/posts/comics.jpg',
                'excerpt' => 'Te recomendamos tres arcos imprescindibles que muestran la versatilidad de Batman y su impacto en la ciudad.',
                'content' => <<<HTML
<p><strong>Batman</strong> ha protagonizado decenas de historias inolvidables, pero hay tres que recomendamos a cualquier fan nuevo o veterano:</p>
<ol>
  <li><strong>Year One</strong>: Ideal para comenzar, explora las raíces del Caballero Oscuro.</li>
  <li><strong>The Long Halloween</strong>: Una investigación que mezcla suspenso y la aparición de varios villanos icónicos.</li>
  <li><strong>White Knight</strong>: Una visión alternativa sobre la relación entre Batman y el Joker.</li>
</ol>
<p>En nuestra tienda encontrarás ediciones especiales de cada una, con portadas variantes y merchandising exclusivo.</p>
HTML,
                'is_featured' => false,
                'published_at' => $now->copy()->subDays(3),
            ],
            [
                'title' => 'Cómo cuidar tu colección de cómics premium',
                'category' => 'Guías',
                'cover_image' => '/images/posts/comics.jpg',
                'excerpt' => 'Descubre tips esenciales para conservar en perfecto estado tus números más valiosos de DC y Marvel.',
                'content' => <<<HTML
<p>Si amas tus cómics tanto como nosotros, sabes que un buen almacenamiento es clave. Te compartimos nuestras recomendaciones de especialistas:</p>
<ul>
  <li>Utiliza bolsas libres de ácido y cambia los cartones de respaldo cada dos años.</li>
  <li>Mantén tus cómics en un ambiente sin humedad y lejos de la luz solar directa.</li>
  <li>Clasifícalos por universo o línea editorial para encontrar rápidamente tus historias favoritas.</li>
</ul>
<p>Explora nuestra sección de accesorios donde encontrarás kits de protección, cajas temáticas y etiquetas personalizadas de Multiverse Comics.</p>
HTML,
                'is_featured' => false,
                'published_at' => $now->copy()->subDay(),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'slug' => Str::slug($post['title']),
                    'category' => $post['category'],
                    'cover_image' => $post['cover_image'],
                    'excerpt' => $post['excerpt'],
                    'content' => $post['content'],
                    'is_featured' => $post['is_featured'],
                    'published_at' => $post['published_at'],
                    'user_id' => $post['user_id'] ?? $authorId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }
}
