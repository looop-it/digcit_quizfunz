<script type="text/javascript">
	Swal.fire({
		title: '本賽季您還可以繼續挑戰，爭取更好成績！',
		text: '',
		type: 'info',
		confirmButtonText: '立即挑戰！',
		width: '64em'
	}).then(function(result) {
		if (result.value) {
			window.location.href = '/competition/participate'
		}
	});
</script>
