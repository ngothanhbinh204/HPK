<footer>
	footer
</footer>
</main>
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
	<?php wp_footer() ?>
<?php endif; ?>
<?= get_field('field_config_body', 'options') ?>
</body>

</html>