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
    $r = db()->query(
        "
        INSERT INTO `users` (`name`, `password`, `created_at`, `updated_at`, `deleted`) VALUES 
        (?, ?, ?, ?, ?),
        (?, ?, ?, ?, ?),
        (?, ?, ?, ?, ?)
        ",
        $params
    );
});

it("prepares and deletes one", function () {
    $cnt = db()->query("SELECT count(*) from users")->one();
    expect($cnt)->toEqual(3);
    db()->query("DELETE from users where id = 1");
    expect(db()->query("SELECT count(*) from users")->one())->toEqual($cnt - 1);
});
