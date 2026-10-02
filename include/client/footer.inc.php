        </div>
    </div>

<!-- FOOTER INSTITUCIONAL UDLA -->
<footer style="background:#1D1D1B; color:#ccc; margin-top:3rem;">

    <!-- Franja de logos institucionales UDLA -->
    <div style="background:#1D1D1B; border-top:4px solid #E8630A; padding:22px 0;">
        <div class="container-xl px-3">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between gap-4">

                <!-- Logo UDLA blanco -->
                <img src="<?php echo ROOT_PATH; ?>images/udla/logo-udla-blanco.png"
                     alt="Logo UDLA"
                     style="max-height:48px; object-fit:contain;">

                <!-- Adscrita a Gratuidad -->
                <img src="<?php echo ROOT_PATH; ?>images/udla/adscrita-gratuidad.png"
                     alt="Adscrita a Gratuidad"
                     style="max-height:48px; object-fit:contain;">

                <!-- CNA Acreditada -->
                <img src="<?php echo ROOT_PATH; ?>images/udla/logo-cna-acreditada.svg"
                     alt="Universidad Acreditada CNA"
                     style="max-height:60px; object-fit:contain;">

                <!-- Digital Education Council -->
                <img src="<?php echo ROOT_PATH; ?>images/udla/dec-white.png"
                     alt="Digital Education Council"
                     style="max-height:48px; object-fit:contain;">

                <!-- AENOR -->
                <img src="<?php echo ROOT_PATH; ?>images/udla/sello-aenor.png"
                     alt="Sello AENOR"
                     style="max-height:56px; object-fit:contain;">

            </div>
        </div>
    </div>

    <!-- Info del footer -->
    <div style="padding:20px 0 16px;">
        <div class="container-xl px-3">
            <div class="row align-items-center text-center text-md-start gy-2">
                <div class="col-md-6 small">
                    <?php echo __('Copyright &copy;'); ?> <?php echo date('Y'); ?>
                    <strong style="color:#fff;"><?php echo Format::htmlchars((string) $ost->company ?: 'UDLA'); ?></strong>
                    &mdash; <?php echo __('All rights reserved.'); ?>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://osticket.com" target="_blank"
                       style="color:#E8630A;font-size:.8rem;text-decoration:none;">
                        <i class="fas fa-external-link-alt me-1"></i>
                        <?php echo __('Helpdesk software - powered by osTicket'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>
</body>
</html>
