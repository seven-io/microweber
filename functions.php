<?php

/**
 * @return array|mixed
 */
function sms77_get_api_key() {
    return get_option('apiKey', sms77_get_option_group());
}

/**
 * @return string
 */
function sms77_get_option_group() {
    return 'admin/sms77';
}

/**
 * @return array|mixed
 */
function sms77_get_sms_from() {
    return get_option('sms_from', sms77_get_option_group());
}

/**
 * @param array $users
 * @return array
 */
function sms77_get_phones(array $users) {
    $to = [];

    foreach ($users as $user) $to[] = $user['phone'];

    return $to;
}

/**
 * @return array
 */
function sms77_get_users() {
    $users = get_users('');

    foreach ($users as $i => $user)
        if (null === $user['phone'] || '' === $user['phone']) unset($users[$i]);

    return $users;
}

/**
 * @param string $endpoint
 * @param array $data
 * @return bool|string
 */
function sms77_post($endpoint, array $data) {
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

/**
 * @param string $to
 * @return bool|string
 */
function sms77_sms($to) {
    return sms77_post('sms', [
        'debug' => $_POST['debug'],
        'delay' => $_POST['delay'],
        'flash' => $_POST['flash'],
        'foreign_id' => $_POST['foreign_id'],
        'from' => $_POST['from'],
        'label' => $_POST['label'],
        'no_reload' => $_POST['no_reload'],
        'performance_tracking' => $_POST['performance_tracking'],
        'text' => $_POST['text'],
        'to' => $to,
    ]);
}

