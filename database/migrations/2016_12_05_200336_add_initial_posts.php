<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;


// adds some posts. This is included in migration because it is just a project for learning and
// we need some initial data after deployment
class AddInitialPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Post::unguard();

        $texts = array(
<<<'EOD'
![enter image description here][1]

Lorem **ipsum** *dolor* sit amet, consectetur adipiscing elit. Nullam vehicula ipsum eget lorem bibendum, a dignissim dui vestibulum. Duis aliquet dignissim ultricies. Vestibulum id diam at eros lacinia dapibus. Donec posuere felis ac leo tempor varius. Nullam interdum nibh sit amet lacinia laoreet. Quisque maximus [google][2] eros non diam molestie vulputate. Phasellus commodo convallis nisi at dapibus.

    print('hello');
    print('world');
    return 0;

Nam molestie commodo quam eu cursus. In aliquam justo ut dui fermentum gravida. Etiam dignissim quam ante, ut lacinia nisl facilisis eu. Curabitur scelerisque tellus nec odio viverra fringilla. Vivamus justo quam, sagittis eu lacus in, ultrices aliquet quam. Aliquam efficitur mattis lacus, et imperdiet ex pellentesque ut. Mauris ac eros auctor, fringilla leo at, mollis turpis. Nulla eget arcu at augue placerat cursus. Donec quis varius turpis, non ultricies sem.

> Sed in luctus ligula. Pellentesque dapibus feugiat tempus.
> Pellentesque mollis cursus nulla ac aliquam.

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula ipsum eget lorem bibendum, a dignissim dui vestibulum. Duis aliquet dignissim ultricies. Vestibulum id diam at eros lacinia dapibus. Donec posuere felis ac leo tempor varius. Nullam interdum nibh sit amet lacinia laoreet. Quisque maximus eros non diam molestie vulputate.

Nullam maximus euismod quam, quis malesuada mauris sollicitudin volutpat. Praesent maximus luctus justo ullamcorper euismod. Donec congue nulla vitae diam porta aliquam. Aenean vulputate fringilla lacus eu suscipit. Donec sed volutpat velit, et congue est. Nam pulvinar faucibus sem, a suscipit erat. Morbi efficitur malesuada lorem, quis convallis ex sodales eget.


  [1]: http://i.imgur.com/Udjsqjc.jpg?1
  [2]: http://google.com
EOD
,<<<'EOD'
![enter image description here][1]

Lorem **ipsum** *dolor* sit amet, consectetur adipiscing elit. Nullam vehicula ipsum eget lorem bibendum, a dignissim dui vestibulum. Duis aliquet dignissim ultricies. Vestibulum id diam at eros lacinia dapibus. Donec posuere felis ac leo tempor varius. Nullam interdum nibh sit amet lacinia laoreet. Quisque maximus [google][2] eros non diam molestie vulputate. Phasellus commodo convallis nisi at dapibus.

 - Item 1
 - Item 2

Nam molestie commodo quam eu cursus. In aliquam justo ut dui fermentum gravida. Etiam dignissim quam ante, ut lacinia nisl facilisis eu. Curabitur scelerisque tellus nec odio viverra fringilla. Vivamus justo quam, sagittis eu lacus in, ultrices aliquet quam. Aliquam efficitur mattis lacus, et imperdiet ex pellentesque ut. Mauris ac eros auctor, fringilla leo at, mollis turpis. Nulla eget arcu at augue placerat cursus. Donec quis varius turpis, non ultricies sem.

> Sed in luctus ligula. Pellentesque dapibus feugiat tempus.
> Pellentesque mollis cursus nulla ac aliquam.

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vehicula ipsum eget lorem bibendum, a dignissim dui vestibulum. Duis aliquet dignissim ultricies. Vestibulum id diam at eros lacinia dapibus. Donec posuere felis ac leo tempor varius. Nullam interdum nibh sit amet lacinia laoreet. Quisque maximus eros non diam molestie vulputate.

Nullam maximus euismod quam, quis malesuada mauris sollicitudin volutpat. Praesent maximus luctus justo ullamcorper euismod. Donec congue nulla vitae diam porta aliquam. Aenean vulputate fringilla lacus eu suscipit. Donec sed volutpat velit, et congue est. Nam pulvinar faucibus sem, a suscipit erat. Morbi efficitur malesuada lorem, quis convallis ex sodales eget.


  [1]: http://i.imgur.com/4D4VuTw.jpg
  [2]: http://google.com
EOD
);
        for ($i = 1; $i <= 10; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $day = str_pad($i * 2, 2, '0', STR_PAD_LEFT);
            $hours = str_pad(8 + $i, 2, '0', STR_PAD_LEFT);
            $minutes = str_pad($i * 3, 2, '0', STR_PAD_LEFT);
            $seconds = str_pad(15 + $i * 3, 2, '0', STR_PAD_LEFT);
            Post::create([
                'title' => "Post $i",
                'content' => $texts[($i - 1) % count($texts)],
                'created_at' => "2015-$month-$day $hours:$minutes:$seconds",
            ]);
        }

        Post::create([
            'title' => 'RobLeg 2016 registration started',
            'content' => <<<'EOD'
Registration for RobLeg 2016 started!

Go to the *Apply* page to fill the application request for your team.

You can do it **until the end of January**.
EOD
,
            'created_at' => '2016-01-02 08:16:19',
        ]);

        Post::create([
            'title' => 'RobLeg 2016 registration finished',
            'content' => <<<'EOD'
Registration for RobLeg 2016 finished.

The contest is scheduled on **February 10th, 10:00**.
EOD
            ,
            'created_at' => '2016-01-31 17:31:00',
        ]);

        Post::create([
            'title' => 'RobLeg 2017 registration started',
            'content' => <<<'EOD'
Registration for RobLeg 2017 started!

Go to the *Apply* page to fill the application request for your team.

The registration will be closed on **January 20th**.
EOD
            ,
            'created_at' => '2016-12-15 09:15:20',
        ]);

        Post::reguard();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('posts')->delete();
    }
}
