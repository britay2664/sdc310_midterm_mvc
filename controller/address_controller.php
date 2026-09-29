<?php
require_once __DIR__ . '/../model/address_db.php';

function address_from_post(array $post): array
{
    return [
        'First' => trim($post['first'] ?? ''),
        'Last' => trim($post['last'] ?? ''),
        'Street' => trim($post['street'] ?? ''),
        'City' => trim($post['city'] ?? ''),
        'State' => trim($post['state'] ?? ''),
        'Zip' => trim($post['zip'] ?? ''),
    ];
}

$connection = get_db_connection();
$editing = false;
$address_no = -1;
$form_address = array_fill_keys(['First', 'Last', 'Street', 'City', 'State', 'Zip'], '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address_no = filter_var($_POST['address_no'] ?? null, FILTER_VALIDATE_INT);

    if (isset($_POST['add'])) {
        add_address($connection, address_from_post($_POST));
        header('Location: address_list.php');
        exit;
    }

    if (isset($_POST['edit']) && $address_no !== false && $address_no > 0) {
        $selected_address = get_address($connection, $address_no);
        if ($selected_address !== null) {
            $form_address = $selected_address;
            $editing = true;
        }
    }

    if (isset($_POST['update']) && $address_no !== false && $address_no > 0) {
        update_address($connection, $address_no, address_from_post($_POST));
        header('Location: address_list.php');
        exit;
    }

    if (isset($_POST['delete']) && $address_no !== false && $address_no > 0) {
        delete_address($connection, $address_no);
        header('Location: address_list.php');
        exit;
    }
}

$addresses = get_addresses($connection);
require __DIR__ . '/../view/address_list_view.php';
