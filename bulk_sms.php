<?php only_admin_access();

if (isset($_POST['seven_bulk_sms'])) $responses = seven_sms();
?>

<?php foreach ((isset($responses) ? $responses : []) as $response): ?>
    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <?= $response ?>

        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>
<?php endforeach; ?>

<form method='post'>
    <input type='hidden' value='1' name='seven_bulk_sms'/>

    <fieldset>
        <legend><?php _e('Search Filters') ?></legend>

        <label>
            <input checked name='filter_is_active' type='checkbox' value='1'/>
            <?php _e('Is Active') ?>
            <span data-toggle="tooltip"
                  title="<?php _e('Retrieve only active users?') ?>">
            <i class="mdi mdi-help-circle"></i></span>
        </label>

        <label>
            <input name='filter_is_admin' type='checkbox' value='1'/>
            <?php _e('Is Admin') ?>
            <span data-toggle="tooltip"
                  title="<?php _e('Retrieve only admin users?') ?>">
            <i class="mdi mdi-help-circle"></i></span>
        </label>

        <label>
            <input checked name='filter_is_verified' type='checkbox' value='1'/>
            <?php _e('Is Verified') ?>
            <span data-toggle="tooltip"
                  title="<?php _e('Retrieve only verified users?') ?>">
            <i class="mdi mdi-help-circle"></i></span>
        </label>
    </fieldset>

    <hr>

    <label>
        <input name='flash' type='checkbox' value='1'>
        <?php _e('Flash') ?>
        <span data-toggle="tooltip"
              title="<?php _e('Flash SMS get displayed directly in the receivers display') ?>">
            <i class="mdi mdi-help-circle"></i></span>
    </label>

    <label>
        <input name='no_reload' type='checkbox' value='1'>
        <?php _e('No Reload Lock') ?>
        <span data-toggle="tooltip"
              title="<?php _e('Enabling this option disables the reload lock preventing dispatch of duplicate SMS (text, type and recipient alike)') ?>">
            <i class="mdi mdi-help-circle"></i></span>
    </label>

    <label>
        <input name='performance_tracking' type='checkbox' value='1'>
        <?php _e('Performance Tracking') ?>
        <span data-toggle="tooltip"
              title="<?php _e('Enable Performance Tracking for URLs found in the message text.') ?>">
            <i class="mdi mdi-help-circle"></i></span>
    </label>

    <div class='mw-ui-field-holder'>
        <label for='delay' class='mw-ui-label'><?php _e('Delay') ?>
            <small class="text-muted d-block mb-2">
                <?php _e('Time-delayed SMS: Accepts an Unix timestamp or a date/time string formatted as yyyy-mm-dd hh:ii.') ?>
            </small>
        </label>
        <input class='mw-ui-field mw-full-width' id='delay' name='delay'/>
    </div>

    <div class='mw-ui-field-holder'>
        <label for='foreign_id' class='mw-ui-label'><?php _e('Foreign ID') ?>
            <small class="text-muted d-block mb-2">
                <?php _e('Provide custom data for the message which gets returned in DLR callbacks etc. Max. 64 chars, allowed characters:') ?>
                <code>a-z, A-Z, 0-9, .-_@</code>.
            </small>
        </label>
        <input class='mw-ui-field mw-full-width' id='foreign_id' maxlength='64'
               name='foreign_id'/>
    </div>

    <div class='mw-ui-field-holder'>
        <label for='label' class='mw-ui-label'><?php _e('Label') ?>
            <small class="text-muted d-block mb-2">
                <?php _e('Optionally set a separate label for each SMS so that you can assign it to your statistics. Max. 100 chars, allowed characters:') ?>
                <code>a-z, A-Z, 0-9, .-_@</code>.
            </small>
        </label>
        <input class='mw-ui-field mw-full-width' id='label' maxlength='100' name='label'/>
    </div>

    <div class='mw-ui-field-holder'>
        <label for='from' class='mw-ui-label'><?php _e('From') ?>
            <small class="text-muted d-block mb-2">
                <?php _e('Sender number. It may contain a maximum of 11 alphanumeric or 16 numeric characters.') ?>
            </small>
        </label>
        <input class='mw-ui-field mw-full-width' id='from' maxlength='16' name='from'
               value='<?= seven_get_sms_from() ?>'/>
    </div>

    <div class='mw-ui-field-holder'>
        <label for='text' class='mw-ui-label'><?php _e('Text') ?>
            <small class="text-muted d-block mb-2">
                <?php _e('The message content. Up to 1520 characters. If more than 160 characters are used, the text is split over several SMS, each calculated individually.') ?>
            </small>
        </label>
        <textarea class='mw-ui-field mw-full-width' id='text' maxlength='1520' name='text'
                  placeholder='<?php _e('Hi {{first_name}} {{last_name}}, you have not logged on since {{last_login}}, did you forget your username {{username}}?') ?>'
                  required></textarea>
    </div>

    <button class='mw-ui-btn mw-ui-btn-medium' type='submit'><?php _e('Send') ?></button>
</form>
