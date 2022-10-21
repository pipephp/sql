<?php

use Pipe\SQL;

it("can get class from function", function () {
    expect(db())->toBeInstanceOf(SQL::class);
});

it("can connect", function () {
    db()->connect("127.0.0.1", "root", "pass", "test");
    expect(db()->connection)->toBeInstanceOf(\PDO::class);
});

it("thows an error on bad credentials", function () {
    expect(db()->connect("127.0.0.1", "nope!", "pass", "test"));
})->throws(\PDOException::class);
