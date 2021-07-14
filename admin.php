<?php only_admin_access();
$module = module_info($params['module']);
$liveEdit = false;
if (isset($params['live_edit']) && $params['live_edit']) $liveEdit = $params['live_edit'];
?>

<?php if (isset($params['backend'])): ?><module type='admin/modules/info'/><?php endif; ?>

<div class='card style-1 mb-3 <?php if ($liveEdit): ?>card-in-live-edit<?php endif; ?>'>
    <div class='card-header'>
        <h5>
            <img src='<?= $module['icon'] ?>' class='module-icon-svg-fill'/>
            <strong><?php _e($module['name']); ?></strong>
        </h5>
    </div>

    <div class='card-body pt-3'>
        <div class='mw-modules-tabs'>
            <div class='mw-accordion-item'>
                <div class='mw-ui-box-header mw-accordion-title'>
                    <div class='header-holder'>
                        <i class='mw-icon-settings'></i> <?php _e('Settings'); ?>
                    </div>
                </div>

                <div class='mw-accordion-content mw-ui-box mw-ui-box-content'>
                    <?php require __DIR__ . DS . 'settings.php'; ?>
                </div>
            </div>

            <div class='mw-accordion-item'>
                <div class='mw-ui-box-header mw-accordion-title'>
                    <div class='header-holder'>
                        <i class='mw-icon-comment'></i> <?php _e('Bulk SMS'); ?>
                    </div>
                </div>
                <div class='mw-accordion-content mw-ui-box mw-ui-box-content'>
                    <?php require __DIR__ . DS . 'bulk_sms.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#accordion').on('hidden.bs.collapse shown.bs.collapse', function (e) {
        $(e.target).prev('.card-header').find('i.mdi.arrow')
            .toggleClass('mdi-chevron-down mdi-chevron-up')
            .toggleClass('active');
    });

    $('.card').click(function () {
        $('.card').removeClass('active');
        $(this).addClass('active');
    });
</script>
