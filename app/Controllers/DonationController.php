<?php

namespace App\Controllers;

class DonationController extends Controller
{
    /**
     * Show donate form
     *
     * @return mixed
     */
    public function __invoke()
    {
        return view('payment.donation.donate');
    }
}
