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
    db()->raw("INSERT INTO `users` (`name`, `password`, `created_at`, `updated_at`, `deleted`)
        VALUES 
        ('2mark', 'pa4$', now(), now(), '0'),
        ('3mark', 'pa4$', now(), now(), '0'),
        ('2mark', 'pa4$', now(), now(), '0'),
        ('5mark', 'pa4$', now(), now(), '0'),
        ('6mark', 'pa4$', now(), now(), '0'),
        ('7mark', 'pa4$', now(), now(), '0')
    ");
});

it("prepares and fetches all", function () {
    $r = db()->query("select * from users");

    expect($r->all())->toBeArray()->toHaveCount(6);
});

it("prepares and fetches first", function () {
    $r = db()->query("select * from users where name = '2mark'");
    $row = $r->first();

    expect($row)->toBeObject();
    expect($row->name)->toEqual("2mark");
});

it("prepares and binds and fetches all", function () {
    $r = db()->query("select * from users where name like :name", ['name' => '%mark']);
    expect($r->all())->toBeArray();
});

it("prepares and returns a count", function () {
    $r = db()->query("select count(id) from users where name like :name", ['name' => '2%']);
    expect($r->one())->toEqual(2);
    $r = db()->query("select count(id) from users where name not like :name", ['name' => '2%']);
    expect($r->one())->toEqual(4);
});
