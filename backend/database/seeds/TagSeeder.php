<?php

use App\Complaint;
use App\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bug = Tag::create(['name' => 'bug']);
        $support = Tag::create(['name' => 'support']);
        $suggestion = Tag::create(['name' => 'suggestion']);

        foreach (Complaint::get() as $complaint) {
            $complaint->tags()->save($bug);
            $complaint->tags()->save($support);
            $complaint->tags()->save($suggestion);
        }
    }
}
