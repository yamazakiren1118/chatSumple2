<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Message::class,20)->create();

        // $this->call(UsersTableSeeder::class);
        // DB::table('channels')->insert([
        //     ['id' => '1',
        //     'name' => 'メイン',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '2',
        //     'name' => '雑談',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '3',
        //     'name' => 'お仕事',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '4',
        //     'name' => 'プログラミング',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '5',
        //     'name' => 'お料理',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '6',
        //     'name' => 'なんでも',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        // ]);
        // DB::table('users')->insert([
        //     ['id' => '1',
        //     'name' => '山崎 蓮',
        //     'email' => 'yamazakiren1118@yahoo.co.jp',
        //     'password' => bcrypt('yamazaki123'),
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '2',
        //     'name' => 'つよし',
        //     'email' => 'tuyoshi@yahoo.co.jp',
        //     'password' => bcrypt('tuyoshii123'),
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '3',
        //     'name' => '山本 ノブ',
        //     'email' => 'nobu@yahoo.co.jp',
        //     'password' => bcrypt('nobu123'),
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '4',
        //     'name' => '春日 アカリ',
        //     'email' => 'akari@yahoo.co.jp',
        //     'password' => bcrypt('akari123'),
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '5',
        //     'name' => '冬原 港',
        //     'email' => 'huyuhara@yahoo.co.jp',
        //     'password' => bcrypt('huyuhara123'),
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        // ]);
        // DB::table('channel_user')->insert([
        //     ['id' => '1',
        //     'user_id' => '1',
        //     'channel_id' => '1',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '2',
        //     'user_id' => '2',
        //     'channel_id' => '1',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '3',
        //     'user_id' => '3',
        //     'channel_id' => '1',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '4',
        //     'user_id' => '4',
        //     'channel_id' => '1',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '5',
        //     'user_id' => '5',
        //     'channel_id' => '1',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],



        //     ['id' => '6',
        //     'user_id' => '1',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '7',
        //     'user_id' => '2',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '8',
        //     'user_id' => '3',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '9',
        //     'user_id' => '4',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '10',
        //     'user_id' => '1',
        //     'channel_id' => '3',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '11',
        //     'user_id' => '1',
        //     'channel_id' => '4',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '12',
        //     'user_id' => '1',
        //     'channel_id' => '5',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        // ]);

        // DB::table('messages')->insert([
        //     ['id' => '1',
        //     'message' => "どうもこんばんは\n調子はどうですか？",
        //     'user_id' => '1',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '2',
        //     'message' => "こんばんは\n最近花粉がつらいです。\n目がかゆい",
        //     'user_id' => '2',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '3',
        //     'message' => "花粉は一年中飛んでいます。\n春が一番多いです。",
        //     'user_id' => '3',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '4',
        //     'message' => "にらを食べると効果的らしいですよ。",
        //     'user_id' => '4',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '5',
        //     'message' => "なるほどありがとうございます。\n早速にら買ってきます。",
        //     'user_id' => '2',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '6',
        //     'message' => "私もにら買おうかな。",
        //     'user_id' => '1',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '7',
        //     'message' => "にら料理は餃子が好きです。\nキムチダレを付けるとおいしい。",
        //     'user_id' => '4',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],

        //     ['id' => '8',
        //     'message' => "私は塩ゆでしたニラに卵醤油をかけたものが好きです。\n簡単に作れておいしいよ。\nおすすめです。",
        //     'user_id' => '3',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '9',
        //     'message' => "なんかニラが全然売ってなかったんだけど\nどういう現象これ？",
        //     'user_id' => '5',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '10',
        //     'message' => "昨日NHKの花粉症対策番組で紹介されてた。\nその影響じゃない。",
        //     'user_id' => '1',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '11',
        //     'message' => "まじかよ\n考えることは同じだな。",
        //     'user_id' => '5',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '12',
        //     'message' => "薬飲んだりはしないの？",
        //     'user_id' => '4',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '13',
        //     'message' => "眠くなるのが嫌なんだよ。\n市販の奴はあまり効かない気がするし\n病院に行くのもめんどくさい",
        //     'user_id' => '5',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '14',
        //     'message' => "アレグラは結構効きますよ\n紫色のパッケージの奴",
        //     'user_id' => '2',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '15',
        //     'message' => "あのCMが面白いやつですね。\n一度見たら忘れられない。",
        //     'user_id' => '4',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '16',
        //     'message' => "眠くなるのが嫌なんだって\n薬飲むと眠くなるじゃん。",
        //     'user_id' => '5',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '17',
        //     'message' => "アレグラは眠くなりにくいですよ。\n個人差あるかもだけど。",
        //     'user_id' => '2',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        //     ['id' => '18',
        //     'message' => "まじか\n試してみようかな",
        //     'user_id' => '5',
        //     'channel_id' => '2',
        //     'created_at' => new DateTime(),
        //     'updated_at' => new DateTime(),
        //     ],
        // ]);
    }
}
