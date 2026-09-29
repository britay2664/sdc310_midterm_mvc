<?php
require_once __DIR__ . '/database.php';

function get_addresses(mysqli $connection): array
{
    $result = $connection->query('SELECT AddressNo, First, Last, Street, City, State, Zip FROM addresses');
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_address(mysqli $connection, int $address_no): ?array
{
    $statement = $connection->prepare(
        'SELECT AddressNo, First, Last, Street, City, State, Zip FROM addresses WHERE AddressNo = ?'
    );
    $statement->bind_param('i', $address_no);
    $statement->execute();
    return $statement->get_result()->fetch_assoc() ?: null;
}

function add_address(mysqli $connection, array $address): void
{
    $statement = $connection->prepare(
        'INSERT INTO addresses (First, Last, Street, City, State, Zip) VALUES (?, ?, ?, ?, ?, ?)'
    );
    $statement->bind_param(
        'ssssss',
        $address['First'], $address['Last'], $address['Street'],
        $address['City'], $address['State'], $address['Zip']
    );
    $statement->execute();
}

function update_address(mysqli $connection, int $address_no, array $address): void
{
    $statement = $connection->prepare(
        'UPDATE addresses SET First = ?, Last = ?, Street = ?, City = ?, State = ?, Zip = ? WHERE AddressNo = ?'
    );
    $statement->bind_param(
        'ssssssi',
        $address['First'], $address['Last'], $address['Street'],
        $address['City'], $address['State'], $address['Zip'], $address_no
    );
    $statement->execute();
}

function delete_address(mysqli $connection, int $address_no): void
{
    $statement = $connection->prepare('DELETE FROM addresses WHERE AddressNo = ?');
    $statement->bind_param('i', $address_no);
    $statement->execute();
}
