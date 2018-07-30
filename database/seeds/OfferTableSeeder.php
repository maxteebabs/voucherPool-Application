<?php

use Illuminate\Database\Seeder;
use App\SpecialOffer;

class OfferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('special_offers')->delete();
        $data = array(
            array('name' => 'Bonaza Promo',
            'percentage_discount' => 70),
            array('name' => 'July Promo',
            'percentage_discount' => 22),
        );
        DB::table('special_offers')->insert($data);
    }
}
