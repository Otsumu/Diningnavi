<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $user1 = User::firstOrCreate(
            ['email' => 'ichiro@tenpo.com'],
            ['name' => '店舗一郎', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user2 = User::firstOrCreate(
            ['email' => 'jiro@tenpo.com'],
            ['name' => '店舗二郎', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user3 = User::firstOrCreate(
            ['email' => 'saburo@tenpo.com'],
            ['name' => '店舗三郎', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user4 = User::firstOrCreate(
            ['email' => 'shiro@tenpo.com'],
            ['name' => '店舗四郎', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user5 = User::firstOrCreate(
            ['email' => 'satsuki@tenpo.com'],
            ['name' => '店舗五月', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user6 = User::firstOrCreate(
            ['email' => 'rokuro@tenpo.com'],
            ['name' => '店舗六郎', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $user7 = User::firstOrCreate(
            ['email' => 'nanako@tenpo.com'],
            ['name' => '店舗七子', 'password' => bcrypt('password'),'role' => 'shop_owner']
        );

        $shops = [
            [
                'name' => '仙人',
                'intro' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'area_id' => 1,
                'genre_id' => 1,
                'user_id' => $user1->id,
                'shop_owner_id' => $user1->id,
            ],
            [
                'name' => '牛助',
                'intro' => '焼肉業界で20年間経験を積み、肉を熟知したマスターによる実力派焼肉店。長年の実績とお付き合いをもとに、なかなか食べられない希少部位も仕入れております。また、ゆったりとくつろげる空間はお仕事終わりの一杯や女子会にぴったりです。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'area_id' => 2,
                'genre_id' => 2,
                'user_id' => $user2->id,
                'shop_owner_id' => $user2->id,
            ],
            [
                'name' => '戦慄',
                'intro' => '気軽に立ち寄れる昔懐かしの大衆居酒屋です。キンキンに冷えたビールを、なんと199円で。鳥かわ煮込み串は販売総数100000本突破の名物料理です。仕事帰りに是非御来店ください。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'area_id' => 3,
                'genre_id' => 3,
                'user_id' => $user3->id,
                'shop_owner_id' => $user3->id,
            ],
            [
                'name' => 'ルーク',
                'intro' => '都心にひっそりとたたずむ、古民家を改築した落ち着いた空間です。イタリアで修業を重ねたシェフによるモダンなイタリア料理とソムリエセレクトによる厳選ワインとのペアリングが好評です。ゆっくりと上質な時間をお楽しみください。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'area_id' => 1,
                'genre_id' => 4,
                'user_id' => $user3->id,
                'shop_owner_id' => $user3->id,
            ],
            [
                'name' => '志摩屋',
                'intro' => 'ラーメン屋とは思えない店内にはカウンター席はもちろん、個室も用意してあります。ラーメンはこってり系・あっさり系ともに揃っています。その他豊富な一品料理やアルコールも用意しており、居酒屋としても利用できます。ぜひご来店をお待ちしております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'area_id' => 3,
                'genre_id' => 5,
                'user_id' => $user3->id,
                'shop_owner_id' => $user3->id,
            ],
            [
                'name' => '香',
                'intro' => '大小さまざまなお部屋をご用意してます。デートや接待、記念日や誕生日など特別な日にご利用ください。皆様のご来店をお待ちしております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'area_id' => 1,
                'genre_id' => 2,
                'user_id' => $user2->id,
                'shop_owner_id' => $user2->id,
            ],  
            [
                'name' => 'JJ',
                'intro' => 'イタリア製ピザ窯芳ばしく焼き上げた極薄のミラノピッツァや厳選されたワインをお楽しみいただけます。女子会や男子会、記念日やお誕生日会にもオススメです。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'area_id' => 2,
                'genre_id' => 4,
                'user_id' => $user1->id,
                'shop_owner_id' => $user1->id,
            ],
            [
                'name' => 'らーめん極み',
                'intro' => '一杯、一杯心を込めて職人が作っております。味付けは少し濃いめです。 食べやすく最後の一滴まで美味しく飲めると好評です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'area_id' => 1,
                'genre_id' => 5,
                'user_id' => $user1->id,
                'shop_owner_id' => $user1->id,
            ],
            [
                'name' => '鳥雨',
                'intro' => '素材の旨味を存分に引き出す為に、塩焼を中心としたお店です。比内地鶏を中心に、厳選素材を職人が備長炭で豪快に焼き上げます。清潔な内装に包まれた大人の隠れ家で贅沢で優雅な時間をお過ごし下さい。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'area_id' => 2,
                'genre_id' => 3,
                'user_id' => $user4->id,
                'shop_owner_id' => $user4->id,
            ],
            [
                'name' => '築地色合',
                'intro' => '鮨好きの方の為の鮨屋として、迫力ある大きさの握りを1貫ずつ提供致します。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'area_id' => 1,
                'genre_id' => 1,
                'user_id' => $user5->id,
                'shop_owner_id' => $user5->id,
            ],
            [
                'name' => '晴海',
                'intro' => '毎年チャンピオン牛を買い付け、仙台市長から表彰されるほどの上質な仕入れをする精肉店オーナーの本当に美味しい国産牛を食べてもらいたいという思いから誕生したお店です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'area_id' => 2,
                'genre_id' => 2,
                'user_id' => $user6->id,
                'shop_owner_id' => $user6->id,
            ],
            [
                'name' => '三子',
                'intro' => '最高級の美味しいお肉で日々の疲れを軽減していただければと贅沢にサーロインを盛り込んだ御膳をご用意しております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'area_id' => 3,
                'genre_id' => 2,
                'user_id' => $user3->id,
                'shop_owner_id' => $user3->id,
            ],
            [
                'name' => '八戒',
                'intro' => '当店自慢の鍋や焼き鳥などお好きなだけ堪能できる食べ放題プランをご用意しております。飲み放題は2時間と3時間がございます。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'area_id' => 1,
                'genre_id' => 3,
                'user_id' => $user7->id,
                'shop_owner_id' => $user7->id,
            ],
            [
                'name' => '福助',
                'intro' => 'ミシュラン掲載店で磨いた、寿司職人の旨さへのこだわりはもちろん、 食事をゆっくりと楽しんでいただける空間作りも意識し続けております。 接待や大切なお食事にはぜひご利用ください。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'area_id' => 2,
                'genre_id' => 1,
                'user_id' => $user7->id,
                'shop_owner_id' => $user7->id,
            ],
            [
                'name' => 'ラー北',
                'intro' => 'お昼にはランチを求められるサラリーマン、夕方から夜にかけては、学生や会社帰りのサラリーマン、小上がり席もありファミリー層にも大人気です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'area_id' => 1,
                'genre_id' => 5,
                'user_id' => $user6->id,
                'shop_owner_id' => $user6->id,
            ],
            [
                'name' => '翔',
                'intro' => '博多出身の店主自ら厳選した新鮮な旬の素材を使ったコース料理をご提供します。一人一人のお客様に目が届くようにしております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'area_id' => 2,
                'genre_id' => 3,
                'user_id' => $user5->id,
                'shop_owner_id' => $user5->id,
            ],
            [
                'name' => '経緯',
                'intro' => '職人が一つ一つ心を込めて丁寧に仕上げた、江戸前鮨ならではの味をお楽しみ頂けます。鮨に合った希少なお酒も数多くご用意しております。他にはない海鮮太巻き、当店自慢の蒸し鮑、是非ご賞味下さい。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'area_id' => 1,
                'genre_id' => 1,
                'user_id' => $user4->id,
                'shop_owner_id' => $user4->id,
            ],
            [
                'name' => '漆',
                'intro' => '店内に一歩足を踏み入れると、肉の焼ける音と芳香が猛烈に食欲を掻き立ててくる。そんな漆で味わえるのは至極の焼き肉です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'area_id' => 1,
                'genre_id' => 2,
                'user_id' => $user4->id,
                'shop_owner_id' => $user4->id,
            ],
            [
                'name' => 'THE TOOL',
                'intro' => '非日常的な空間で日頃の疲れを癒し、ゆったりとした上質な時間を過ごせる大人の為のレストラン&バーです。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'area_id' => 3,
                'genre_id' => 4,
                'user_id' => $user6->id,
                'shop_owner_id' => $user6->id,
            ],
            [
                'name' => '木船',
                'intro' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'area_id' => 2,
                'genre_id' => 1,
                'user_id' => $user1->id,
                'shop_owner_id' => $user1->id,
            ],
        ];

        foreach ($shops as $shop) {
            DB::table('shops')->insert([
                'name' => $shop['name'],
                'intro' => $shop['intro'],
                'image_url' => $shop['image_url'],
                'area_id' => $shop['area_id'],
                'genre_id' => $shop['genre_id'],
                'user_id' => $shop['user_id'],
                'shop_owner_id' => $shop['shop_owner_id'],
            ]);
        }
    }
}