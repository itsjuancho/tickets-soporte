$('#atender').on("click", function() {
	let tid = document.getElementById('attend_tid').value;
	let t_id = document.getElementById('attend_tickid').value;
	$.ajax({
		url: "soporte/atender_ticket",
		type: "POST",
		data: {tid,t_id},
		success: function(resp) {
			const Toast = Swal.mixin({
		  		toast: true,
		  		position: 'center',
		  		showConfirmButton: false,
		  		timer: 3500,
		  		timerProgressBar: true,
		  		onOpen: (toast) => {
		    		toast.addEventListener('mouseenter', Swal.stopTimer)
		    		toast.addEventListener('mouseleave', Swal.resumeTimer)
		  		}
			});

			Toast.fire({
			  icon: 'success',
			  title: 'Ticket atendido!'
			});
		}
	});
});