<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<footer id="footer" role="contentinfo" class="container text-center flex items-center justify-center h-16 text-gray-400">
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="https://typecho.org">Typecho</a> 强力驱动'); ?>. <?php _e('Theme By <a href="https://xiaopanglian.com">Icefox</a>'); ?>
</footer><!-- end #footer -->

<?php $this->footer(); ?>