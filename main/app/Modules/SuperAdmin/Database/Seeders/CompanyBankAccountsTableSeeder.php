<?php
namespace App\Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyBankAccountsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('company_bank_accounts')->delete();

    \DB::table('company_bank_accounts')->insert(array(
      0 =>
      array(
        'bank' => 'UBA',
        'account_name' => 'Cole Fay IV',
        'account_number' => '49091858',
        'account_type' => 'Auto Loan Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'viral enhance networks',
      ),
      1 =>
      array(
        'bank' => 'Zenith',
        'account_name' => 'Dennis Altenwerth',
        'account_number' => '25737726',
        'account_type' => 'Home Loan Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'open-source engineer experiences',
      ),
      2 =>
      array(
        'bank' => 'Sterling',
        'account_name' => 'Kacie Labadie',
        'account_number' => '08086053',
        'account_type' => 'Home Loan Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'open-source expedite portals',
      ),
      3 =>
      array(
        'bank' => 'Access',
        'account_name' => 'Mariane VonRueden',
        'account_number' => '29344924',
        'account_type' => 'Savings Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'bleeding-edge whiteboard markets',
      ),
      4 =>
      array(
        'bank' => 'Access (Diamond)',
        'account_name' => 'Oran O\'Kon',
        'account_number' => '06248504',
        'account_type' => 'Investment Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'turn-key incentivize web services',
      ),
      5 =>
      array(
        'bank' => 'Eco Bank',
        'account_name' => 'Nona Parisian IV',
        'account_number' => '50465521',
        'account_type' => 'Credit Card Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'front-end matrix paradigms',
      ),
      6 =>
      array(
        'bank' => 'GTB',
        'account_name' => 'Evelyn Abshire',
        'account_number' => '17380612',
        'account_type' => 'Checking Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'granular empower niches',
      ),
      7 =>
      array(
        'bank' => 'Polaris',
        'account_name' => 'Selena O\'Kon',
        'account_number' => '58156154',
        'account_type' => 'Home Loan Account',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'customized utilize communities',
      ),
      8 =>
      array(
        'bank' => 'Cash',
        'account_name' => 'Office',
        'account_number' => 'Office',
        'account_type' => 'Cash Transaction',
        'img_url' => 'http://lorempixel.com/640/480/business',
        'account_description' => 'cash transactions',
      ),
    ));
  }
}
