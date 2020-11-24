<?php
use App\User;
use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author1 = App\User::create([
            'name' => 'John dor',
            'email' => 'john@.com',
            'password' => Hash::make('password')
        ]);

        $author2 = App\User::create([
            'name' => 'Jonyy dor',
            'email' => 'jonyy@.com',
            'password' => Hash::make('password')
        ]);

        $author3 = App\User::create([
            'name' => 'Jona dor',
            'email' => 'jona@.com',
            'password' => Hash::make('password')
        ]);

        $category1 = Category::create([
                'name' => 'News',
            ]);
        $category2 = Category::create([
                'name' => 'kenderaan',
            ]);
        $category3 = Category::create([
                'name' => 'maknanr',
            ]);

        $post1 = Post::create([
            'title' => 'We relocated our office to a new designed garage',
            'description' => 'pmakaakmk kmkmk makanan ',
            'content' => 'ayam ayam ayam',
            'category_id' => $category1->id,
            'image' => 'posts/1.jpg',
            'user_id' => $author1->id
        ]);

        $post2 = $author2->posts()->create([
            'title' => 'Top 5 brilliant content marketing strategies',
            'description' => 'pmakaakmk kmkmk makanan ',
            'content' => 'ayam ayam ayam',
            'category_id' => $category2->id,
            'image' => 'posts/2.jpg',

        ]);

        $post3 =$author1->posts()->create([
            'title' => 'Best practices for minimalist design with example',
            'description' => 'pmakaakmk kmkmk makanan ',
            'content' => 'ayam ayam ayam',
            'category_id' => $category3->id,
            'image' => 'posts/3.jpg',

        ]);


        $tag1 = Tag::create([
            'name' => 'kaler',
        ]);
        $tag2 = Tag::create([
            'name' => 'bau',
        ]);
        $tag3 = Tag::create([
            'name' => 'speed',
        ]);

        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag2->id, $tag3->id]);
        $post3->tags()->attach([$tag1->id, $tag3->id]);
    }
}
