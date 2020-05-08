const MainMixin = {
	data(){
		return {
			user: window.user,
			MESSAGE_TYPE_INFORMATION: 0,
			MESSAGE_TYPE_ERROR: 1,
			MESSAGE_TYPE_WARNING: 2,
			MESSAGE_TYPE_CONFIRMATION: 3,
			MESSAGE_TYPE_SUCCESS: 4,
		};
	},
	methods: {
        hideAlert(){
            $(".alert").hide();
        },
		notify(message, new_icon = "pe-7s-close", type = "danger"){
            $.notify({
                new_icon,
                message
            },{
                type,
                timer: 2000
            });
        },
        showLoading(){
			Swal.fire({
				text: 'Cargando',
				onOpen() {
					Swal.showLoading();
				},
				allowOutsideClick: false,
			  });
		},
		stopLoading(){
			Swal.close();
		},
		ShowMessagePopup(message, type) {
			var typeClass = "primary";
			switch (type) {
				case this.MESSAGE_TYPE_SUCCESS:
					typeClass = "success";
					break;
				case this.MESSAGE_TYPE_ERROR:
					typeClass = "error";
					break;
				case this.MESSAGE_TYPE_WARNING:
					typeClass = "warning";
					break;
				case this.MESSAGE_TYPE_INFORMATION:
					typeClass = "primary";
					break;
				default:
					typeClass = "dark";
					break;
			}
		
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				onOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});
			Toast.fire({
				icon: typeClass,
				title: message
			});
		},

		ShowModalMessage(message, type){
			let typeClass = "primary";
			let title = "";
			switch (type) {
				case this.MESSAGE_TYPE_SUCCESS:
					typeClass = "success";
					title = "Correcto";
					break;
				case this.MESSAGE_TYPE_ERROR:
					typeClass = "error";
					title = "Error";
					break;
				case this.MESSAGE_TYPE_WARNING:
					typeClass = "warning";
					title = "Advertencia";
					break;
				case this.MESSAGE_TYPE_INFORMATION:
					typeClass = "info";
					break;
				default:
					typeClass = "";
					title = "";
					break;
			}
			Swal.fire({
				icon: typeClass,
				title: title,
				text: message
			  });
		}
	},
};

export default MainMixin;
