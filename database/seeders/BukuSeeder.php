<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; 

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Buku::truncate();
        Schema::enableForeignKeyConstraints();

        $bukuData = [
            [
                'id' => 1, 'judul' => 'Lord of Mysteries, Vol. 1: The Clown, Part 1', 'barcode' => '20250912-aN5TlW',
                'author' => 'Cuttlefish That Loves Diving', 'isbn' => '978-1-95-228114-1',
                'jenis_id' => 1, 'kondisi' => 'Baik', 'stok' => 7,
                'gambar' => 'gambar-buku/tg6Y5ffts6xfDQUlTKRx1xZQ0m3pGbEf7JYjDBSA.jpg',
                'created_at' => '2025-08-13 12:53:47', 'updated_at' => '2025-09-12 21:17:03'
            ],
            [
                'id' => 2, 'judul' => 'Lord of Mysteries, Vol. 2: The Clown, Part 2', 'barcode' => '20250912-RSEJtN',
                'author' => 'Cuttlefish That Loves Diving', 'isbn' => '978-1-95-228115-8',
                'jenis_id' => 1, 'kondisi' => 'Baik', 'stok' => 4,
                'gambar' => 'gambar-buku/7ujOgv5BnRQ8HNuovRBySt2h6UAesHC3shQ4VEF9.jpg',
                'created_at' => '2025-08-13 13:00:24', 'updated_at' => '2025-09-12 21:18:43'
            ],
            [
                'id' => 3, 'judul' => 'Laskar Pelangi', 'barcode' => '20250912-oYYUCN',
                'author' => 'Andrea Hirata', 'isbn' => '978-9-79-306279-2',
                'jenis_id' => 1, 'kondisi' => 'Baik', 'stok' => 15,
                'gambar' => 'gambar-buku/44uFlzpyPlbCGTRp2Mhn1BDWwPZlFbLcVp9Do6kg.jpg',
                'created_at' => '2025-09-10 21:36:50', 'updated_at' => '2025-09-12 21:19:39'
            ],
            [
                'id' => 4, 'judul' => 'Bumi Manusia', 'barcode' => '20250912-KXTAFD',
                'author' => 'Pramoedya Ananta Toer', 'isbn' => '978-9-79-973123-4',
                'jenis_id' => 15, 'kondisi' => 'Baik', 'stok' => 15,
                'gambar' => 'gambar-buku/XQRA5TwU8roQ0VmTv1wK6PqBwHsNSZOukGV4Bk7Q.jpg',
                'created_at' => '2025-09-10 21:38:26', 'updated_at' => '2025-09-12 21:19:20'
            ],
            [
                'id' => 5, 'judul' => 'Harry Potter and the Philosopher’s Stone', 'barcode' => '20250912-vVwwZ5',
                'author' => 'J.K. Rowling', 'isbn' => '978-0-74-753274-3',
                'jenis_id' => 9, 'kondisi' => 'Baik', 'stok' => 5,
                'gambar' => 'gambar-buku/0p8FaolGwuORAJbAAVKkFmp5Pow1gpMLvul8UxWs.jpg',
                'created_at' => '2025-09-10 21:39:33', 'updated_at' => '2025-09-29 13:59:32'
            ],
            [
                'id' => 6, 'judul' => 'The Lord of the Rings: The Fellowship of the Ring', 'barcode' => '20250912-UY6ZpZ',
                'author' => 'J.R.R. Tolkien', 'isbn' => '978-0-61-864015-7',
                'jenis_id' => 9, 'kondisi' => 'Baik', 'stok' => 10,
                'gambar' => 'gambar-buku/OJUNKzNi2RpLa26CQdGQnW4GLpbMIlqWNn8Grwxq.jpg',
                'created_at' => '2025-09-10 21:40:28', 'updated_at' => '2025-09-29 14:01:29'
            ],
            [
                'id' => 7, 'judul' => 'To Kill a Mockingbird', 'barcode' => '20250912-5f1e8S',
                'author' => 'Harper Lee', 'isbn' => '978-0-06-112008-4',
                'jenis_id' => 13, 'kondisi' => 'Kurang Baik', 'stok' => 5,
                'gambar' => 'gambar-buku/rgtsg2AbkSqqEd92KqchaGOIF0a31XK89lkux02a.jpg',
                'created_at' => '2025-09-10 21:41:20', 'updated_at' => '2025-09-29 13:55:49'
            ],
            [
                'id' => 8, 'judul' => 'The Da Vinci Code', 'barcode' => '20250912-XsgrId',
                'author' => 'Dan Brown', 'isbn' => '978-0-30-747427-8',
                'jenis_id' => 14, 'kondisi' => 'Baik', 'stok' => 10,
                'gambar' => 'gambar-buku/VARdKE1pjSv3ZBD9CMyaTFDB0P4BOcOZ79SbmpkX.jpg',
                'created_at' => '2025-09-10 21:42:16', 'updated_at' => '2025-09-12 21:17:57'
            ],
            [
                'id' => 9, 'judul' => 'Thinking, Fast and Slow', 'barcode' => '20250912-OAe9Ef',
                'author' => 'Daniel Kahneman', 'isbn' => '978-0-37-453355-7',
                'jenis_id' => 16, 'kondisi' => 'Baik', 'stok' => 12,
                'gambar' => 'gambar-buku/tR8B0LTmsKkbBJo7V5tXMEC9kP0mxuJ09JxnOlM8.jpg',
                'created_at' => '2025-09-10 21:43:11', 'updated_at' => '2025-09-12 21:17:48'
            ],
            [
                'id' => 10, 'judul' => 'Sapiens: A Brief History of Humankind', 'barcode' => '20250912-x7yu0m',
                'author' => 'Yuval Noah Harar', 'isbn' => '978-0-06-231609-7',
                'jenis_id' => 15, 'kondisi' => 'Baik', 'stok' => 3,
                'gambar' => 'gambar-buku/KtduRMYCvbta3VMTOQPEJuoXEc41syZB8nsyIrqn.jpg',
                'created_at' => '2025-09-10 21:44:03', 'updated_at' => '2025-09-29 13:15:53'
            ],
            [
                'id' => 11, 'judul' => 'Atomic Habits', 'barcode' => '20250912-KEOjJL',
                'author' => 'James Clear', 'isbn' => '978-0-73-521129-2',
                'jenis_id' => 3, 'kondisi' => 'Baik', 'stok' => 15,
                'gambar' => 'gambar-buku/j2JH68KpaorayYQn9XCYJ81aR4nGnekKV7c6SsW9.jpg',
                'created_at' => '2025-09-10 21:44:49', 'updated_at' => '2025-09-12 21:17:38'
            ],
        ];

        Buku::insert($bukuData);

        foreach (Buku::all() as $buku) {
            $buku->save(); 
        }
    }
}