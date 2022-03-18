<?php

namespace App\Tution\Repositories;

interface SchoolRepository
{
    function getOne($id);

    function get();

    function getByOwner($ownerID);

    function create($input);

    function update($id, $input);

    function updateStatus($id, $status);

    function softDelete($id);

    function delete($id);
}
