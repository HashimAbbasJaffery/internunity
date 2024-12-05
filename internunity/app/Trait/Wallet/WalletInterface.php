<?php

namespace App\Trait\Wallet;

interface WalletInterface
{
    public function add($amount);
    public function subtract($amount);
    public function balance();
}
