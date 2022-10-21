<?php

use Pipe\SQL;

function db(): SQL
{
    return SQL::getInstance();
}
