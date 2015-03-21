<script src="<?=$this->url['assets_url']?>/js/jquery-2.1.3.min.js"></script>
<script src="<?=$this->url['assets_url']?>/js/bootstrap.min.js"></script>

<script>
	$(document).on('change','input[name="check_all"]',function() {
		$('input[id="checkbox"]').prop("checked" , this.checked);
	});
</script>

</body>
</html>