<?php

use Pipe\SQL;

it("can connect", function () {
    $db = new SQL();
    $db->connect("127.0.0.1", "root", "pass", "test");
    expect($db->connection)->toBeInstanceOf(\PDO::class);
});

it("thows an error on bad credentials", function () {
    expect((new SQL())->connect("127.0.0.1", "nope!", "pass", "test"));
})->throws(\PDOException::class);
