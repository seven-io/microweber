<?php

function sms77_get_api_key() {
    return get(sms77_get_options(), 'apiKey');
}

function sms77_get_options() {
    return json_decode(get_module_option('settings', 'admin/sms77'), true);
}

function sms77_get_phones(array $users) {
    $to = [];

    foreach ($users as $user) $to[] = $user['phone'];

    return $to;
}

function sms77_get_users() {
    $users = get_users('');

    foreach ($users as $i => $user)
        if (null === $user['phone'] || '' === $user['phone']) unset($users[$i]);

    return $users;
}

function sms77_post($endpoint, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://gateway.sms77.io/api/" . $endpoint);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-type: application/json',
        'SentWith: Microweber',
        'X-Api-Key: ' . sms77_get_api_key(),
    ]);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function sms77_sms($data) {
    return sms77_post('sms', $data);
}

