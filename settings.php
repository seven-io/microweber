<?php only_admin_access() ?>

<div class='module-live-edit-settings'>
    <div class='setting-item' id='setting-item'>
        <div class="form-group">
            <div class='mw-ui-box-content mw-accordion-content'>
                <h2><?php _e('General') ?></h2>

                <div class='mw-ui-field-holder'>
                    <label class='control-label' for='apiKey'>
                        <?php _e('API Key') ?></label>
                    <input class='form-control mw_option_field'
                           id='apiKey'
                           maxlength='90'
                           name='apiKey'
                           option-group='<?= sms77_get_option_group() ?>'
                           type='text'
                           value='<?= sms77_get_api_key() ?>'
                    />
                </div>

                <hr>

                <h2><?php _e('SMS') ?></h2>

                <div class='mw-ui-field-holder'>
                    <label class='control-label' for='sms_from'>
                        <?php _e('From') ?></label>
                    <input class='form-control mw_option_field'
                           id='sms_from'
                           maxlength='16'
                           name='sms_from'
                           option-group='<?= sms77_get_option_group() ?>'
                           type='text'
                           value='<?= sms77_get_sms_from() ?>'
                    />
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    sms77_settings = {
        init: function (item) {
            $(item.querySelectorAll('input[type="text"]')).on('keyup', function () {
                mw.on.stopWriting(this, function () {
                    console.log('sms77_settings:OnStopWriting');

                    sms77_settings.save();
                });
            });
        },
        collect: function () {
            var all = document.querySelectorAll('.setting-item');
            var data = {};

            for (var i = 0; i < all.length; i++)
                data.apiKey = all[i].querySelector('input[name=apiKey]').value;

            return data;
        },
        save: function () {
            mw.$('#settingsfield').val(JSON.stringify(sms77_settings.collect()))
                .trigger('change');
        }
    };

    $(document).ready(function () {
        mw.options.form('.<?= $config['module_class'] ?>', function () {
            mw.notification.success("<?php _ejs("All changes are saved") ?>.");
        });

        var all = document.querySelectorAll('.setting-item'), l = all.length, i = 0;

        for (; i < l; i++) {
            if (!!all[i].prepared) continue;
            all[i].prepared = true;
            sms77_settings.init(all[i]);
        }
    });
</script>
