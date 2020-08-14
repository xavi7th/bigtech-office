window._ = require('lodash');
window.swal = require('sweetalert2')

window.Toast = swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 2000,
	icon: "success"
});
let timerInterval;

window.ToastLarge = swal.mixin({
	icon: "success",
	title: 'To be implemented!',
	html: 'I will close in <b></b> milliseconds.',
	timer: 3000,
	timerProgressBar: true,
	onBeforeOpen: () => {
		swal.showLoading()
		// timerInterval = setInterval( () => {
		//     const content = swal.getContent()
		//     if ( content ) {
		//         const b = content.querySelector( 'b' )
		//         if ( b ) {
		//             b.textContent = Swal.getTimerLeft()
		//         }
		//     }
		// }, 100 )
	},
	// onClose: () => {
	//     clearInterval( timerInterval )
	// }
})

window.BlockToast = swal.mixin({
	showConfirmButton: true,
	onBeforeOpen: () => {
		swal.showLoading()
	},
	showCloseButton: false,
	allowOutsideClick: false,
	allowEscapeKey: false
});

window.swalPreconfirm = swal.mixin({
	title: 'Are you sure?',
	text: "Implement this when you call the mixin",
	icon: 'question',
	showCloseButton: false,
	allowOutsideClick: () => !swal.isLoading(),
	allowEscapeKey: false,
	showCancelButton: true,
	focusCancel: true,
	cancelButtonColor: '#d33',
	confirmButtonColor: '#3085d6',
	confirmButtonText: 'To be implemented',
	showLoaderOnConfirm: true,
	preConfirm: () => {
		/** Implement this when you call the mixin */
	},
})

/**
 * Implement this when you call the mixin
 * .then( ( result ) => {} );
 */

/**
 * Transforms an error object into HTML string
 *
 * @param {String|Array|null} errors The errors to transform
 */
export const getErrorString = errors => {

	if (_.isString(errors)) {
		var errs = errors;
	} else if (_.size(errors) == 1) {
		var errs = _.reduce(errors, function(val, n) {
			return val.join("<br>") + "<br>" + n;
		})[0];
	} else {
		var errs = _.reduce(errors, function(val, n) {
			return (_.isString(val) ? val : val.join("<br>")) + "<br>" + n;
		});
	}
	return errs
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
