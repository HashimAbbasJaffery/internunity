<?php

namespace App\Trait\Wallet;

trait Wallet
{
    protected $wallet_name = "balance";
    public function add($amount) {
        $this->{$this->wallet_name} += $amount;
        $this->save();

    }
    public function subtract($amount) {
        if($this->balance() < $amount) return;
        $this->{$this->wallet_name} -= $amount;
        $this->save();
    }
    public function balance(): int {
        return $this->{$this->wallet_name};
    }
}
