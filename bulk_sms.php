<?php only_admin_access();

if (isset($_POST['sms77_bulk_sms'])) $responses[] = sms77_sms([
    'text' => $_POST['text'],
    'to' => implode(',', sms77_get_phones(sms77_get_users())),
]);
?>

<?php foreach ((isset($responses) ? $responses : []) as $response): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= $response ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endforeach; ?>

<form method='post'>
    <input type='hidden' value='1' name='sms77_bulk_sms'/>

    <div class='mw-ui-field-holder'>
        <label for='text' class='mw-ui-label'>Text</label>
        <textarea id='text' name='text' class='mw-ui-field mw-full-width'
                  required></textarea>
    </div>

    <button class='mw-ui-btn mw-ui-btn-medium' type='submit'><?php _e('Send') ?></button>
</form>
