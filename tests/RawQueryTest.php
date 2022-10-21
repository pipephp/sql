<?php

use Pipe\SQL;

beforeAll(function () {
    db()->connect("127.0.0.1", "root", "pass", "test");
});

it("cat run raw queries", function () {
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
        ('4mark', 'pa4$', now(), now(), '0'),
        ('5mark', 'pa4$', now(), now(), '0'),
        ('6mark', 'pa4$', now(), now(), '0'),
        ('7mark', 'pa4$', now(), now(), '0')
    ");
    $r = db()->raw("select * from users");

    expect($r->stmt->fetchAll())->toBeArray()->toHaveCount(6);
});

it("cat run raw queries and fetch first", function () {
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
        ('4mark', 'pa4$', now(), now(), '0'),
        ('5mark', 'pa4$', now(), now(), '0'),
        ('6mark', 'pa4$', now(), now(), '0'),
        ('7mark', 'pa4$', now(), now(), '0')
    ");
    $r = db()->raw("select * from users")->stmt->fetch();

    expect($r)->toBeObject();
    expect($r->id)->toEqual(1);
    expect($r->name)->toEqual("2mark");
});
