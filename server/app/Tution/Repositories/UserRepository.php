<?php

namespace App\Tution\Repositories;

interface UserRepository
{
    function getOne(int $id);

    function getByEmail(string $email);

    function get();

    function create($input);

    function update($id, $input);

    function verify($id);

    function verifySession($id);

    function wrongAttempted($id);

    function updateStatus($id, $status);

    function createSession($id);

    function delete($id);
}
