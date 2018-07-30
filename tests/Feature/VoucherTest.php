<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoucherTest extends TestCase
{
    /**
     * Vouchers test
     *
     * @return void
     */
    public function testVouchers()
    {
        $response = $this->get('/vouchers');
        $response->assertStatus(200);
    }
    /**
     * A create Voucher Test
     *
     * @return void
     */
    public function testCreateVoucher()
    {
        $response = $this->post('/voucher/create');
        $response->assertStatus(200);
    }
    /**
     * Add User Test
     *
     * @return void
     */
    public function testAddUser()
    {
        $response = $this->post('/user/add');
        $response->assertStatus(200);
    }
    /**
     * Redeem Voucher Test
     *
     * @return void
     */
    public function testRedeemVoucher()
    {
        $response = $this->post('/voucher/redeem');
        $response->assertStatus(200);
    }
    /**
     * getValidVoucherCodesByEmail Test
     *
     * @return void
     */
    public function testGetValidVoucherCodesByEmail()
    {
        $response = $this->post('/email');
        $response->assertStatus(200);
    }
}
