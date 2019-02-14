<!-- Tinymce component -->
<script src="<?= base_url() ?>assets/js/tinymce/tinymce.min.js"></script>

<script>
	tinymce.init({
		selector: '#texto_noticia',
		elementpath: false,
		height: 300,
		statusbar: false,
		plugins: [
			"advlist autolink lists link charmap preview",
			"media table contextmenu paste"
		]
	});
</script>