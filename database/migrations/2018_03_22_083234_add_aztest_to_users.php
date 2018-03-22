<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class AddAztestToUsers extends Migration
{
    const AMAZON_TEST_USER_ID = 100;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = User::find(self::AMAZON_TEST_USER_ID);
        if ($user) {
            die("Amazon test user existiert bereits");
        }
        $user = new User();
        $user->id = self::AMAZON_TEST_USER_ID;
        $user->name = 'Amazon Test';
        $user->email = 'aztest@example.com';
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
