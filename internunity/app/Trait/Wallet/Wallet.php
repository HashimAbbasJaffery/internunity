<?php

namespace App\Trait\Wallet;

trait Wallet
{
    protected $wallet_name = "balance";
    public function add($amount) {
        $this->wallet->{$this->wallet_name} += $amount;
        $this->save();

    }
    public function subtract($amount) {
        if($this->balance() < $amount) return false;
        $this->wallet->{$this->wallet_name} -= $amount;
        $this->save();
        return true;
    }
    public function balance(): int {
        return $this->wallet->{$this->wallet_name};
    }
}
