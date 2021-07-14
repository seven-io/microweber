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
    $filters = [];

    if (isset($_POST['filter_is_active']))
        $filters[] = 'is_active=' . $_POST['filter_is_active'];
    if (isset($_POST['filter_is_admin']))
        $filters[] = 'is_admin=' . $_POST['filter_is_admin'];
    if (isset($_POST['filter_is_verified']))
        $filters[] = 'is_verified=' . $_POST['filter_is_verified'];

    $users = get_users(implode('&', $filters));
    if (!is_array($users)) $users = [];

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
    curl_setopt($ch, CURLOPT_URL, 'https://gateway.sms77.io/api/' . $endpoint);

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
    $params = ['text' => $_POST['text'], 'to' => $to,];

    foreach (['debug', 'delay', 'flash', 'foreign_id', 'from', 'label', 'no_reload',
                 'performance_tracking'] as $param)
        if (isset($_POST[$param])) $params[$param] = $_POST[$param];

    return sms77_post('sms', $params);
}

