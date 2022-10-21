<?php

use Pipe\SQL;

beforeAll(function () {
    db()->connect("127.0.0.1", "root", "pass", "test");
    db()->raw("DROP TABLE IF EXISTS users");
    db()->raw("CREATE TABLE `users` (
      `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `name` varchar(100) NOT NULL,
      `password` varchar(255) NOT NULL,
      `created_at` datetime NOT NULL,
      `updated_at` datetime NOT NULL,
      `deleted` tinyint(1) NOT NULL
    )");
});

it("prepares and inserts one", function () {
    $r = db()->prepared(
        "INSERT INTO `users` (`name`, `password`, `created_at`, `updated_at`, `deleted`)
        VALUES (:name, :password, :created_at, :updated_at, :deleted)",
        [
            'name' => 'fName lName 0',
            'password' => 'pwd0',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            "deleted" => 1
        ],
    );

    expect(db()->lastInsertId())->toEqual(1);
    expect(db()->raw("SELECT name FROM users")->one())
        ->toBeString()
        ->toEqual("fName lName 0");
});

it("prepares and inserts many", function () {
    $params = [];
    for ($i = 0; $i < 3; $i++) {
        $params = array_merge(
            $params,
            [
                'fName lName ' . $i,
                'pwd' . $i,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                1,
            ]
        );
    }
    $r = db()->prepared(
        "
        INSERT INTO `users` (`name`, `password`, `created_at`, `updated_at`, `deleted`) VALUES 
        (?, ?, ?, ?, ?),
        (?, ?, ?, ?, ?),
        (?, ?, ?, ?, ?)
        ",
        $params
    );
    expect(db()->raw("SELECT name FROM users LIMIT 1 OFFSET 3")->one())
        ->toBeString()
        ->toEqual("fName lName 2");
});
