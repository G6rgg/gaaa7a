<?php

use Medoo\Medoo;

require __DIR__ . '/../api/vendor/autoload.php';

class CPMPolaDB {
    private $database;

    public function __construct() {
        $this->database = new Medoo([
            'type' => 'mysql',
            'host' => 'localhost',
            'database' => 'your database',
            'username' => 'database name',
            'password' => 'database password'
        ]);
    }

    public function isExist($telegram_id) {
        return $this->database->has('customers', ['telegram_id' => $telegram_id]);
    }

    public function addCustomer($coins, $telegram_id) {
        return $this->database->insert('customers', [
            'coins' => $coins,
            'telegram_id' => $telegram_id
        ])->rowCount();
    }

    public function getCustomer($telegram_id) {
        return $this->database->get('customers', '*', ['telegram_id' => $telegram_id]);
    }

    public function setAccessKey($telegram_id, $access_key) {
        $this->database->update('customers', ['access_key' => $access_key], ['telegram_id' => $telegram_id]);
    }

    public function setCoins($telegram_id, $coins) {
        $this->database->update('customers', ['coins' => $coins], ['telegram_id' => $telegram_id]);
    }

    public function giveCoins($telegram_id, $coins) {
        $this->database->update('customers', ['coins[+]' => $coins], ['telegram_id' => $telegram_id]);
    }

    public function takeCoins($telegram_id, $coins) {
        $this->database->update('customers', ['coins[-]' => $coins], ['telegram_id' => $telegram_id]);
    }

    public function setIsUnlimited($telegram_id, $is_unlimited) {
        $this->database->update('customers', ['is_unlimited' => $is_unlimited], ['telegram_id' => $telegram_id]);
    }

    public function setIsBlocked($telegram_id, $is_blocked) {
        $this->database->update('customers', ['is_blocked' => $is_blocked], ['telegram_id' => $telegram_id]);
    }

    public function setTelegramId($access_key, $telegram_id) {
        $this->database->update('customers', ['telegram_id' => $telegram_id], ['access_key' => $access_key]);
    }

    public function getStatics() {
        $customers = $this->database->select("customers", "*");
        $accounts  = $this->database->select("customers_data", "*");
        return [count($customers), count($accounts)];
    }

    public function getAccounts() {
        $accounts  = $this->database->select("customers_data", "*");
        return $accounts;
    }
}