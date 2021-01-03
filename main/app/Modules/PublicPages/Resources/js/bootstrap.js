window._ = require('lodash');
window.swal = require('sweetalert2')

route();

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

export const toCurrency = (amount, currencySymbol = '₦') => {
	if (isNaN(amount)) {
		console.log(amount);
		return 'Invalid Amount';
	}
	return currencySymbol + amount.toFixed(2)
		.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
}

export const displayTableSum = (tableColumn) => {
		return function(row, data, start, end, display) {

				var api = this.api(),
					data;

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === "string" ? // ? i.replace(/[\$,]/g, "") * 1
						i.substring(0, i.lastIndexOf("."))
						.replace(/\D/g, "") * 1 :
						typeof i === "number" ?
						i :
						0;
				};

				// Total over all pages
				let total = api
					.column(tableColumn)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

        // Total over this page
        let pageTotal = api
        	.column(tableColumn, { page: "current" })
        	.data()
        	.reduce(function(a, b) {
        		return intVal(a) + intVal(b);
        	}, 0);

        // Update footer
        jQuery(api.column(2)
        		.footer())
        	.html(
        		toCurrency(pageTotal) + " (" + toCurrency(total) + " total)"
        	);
        }
        }

import { InertiaApp } from '@inertiajs/inertia-svelte'
import { Inertia } from "@inertiajs/inertia";

const app = document.getElementById('app')
let isMobile, isDesktop;

let mediaHandler = () => {
	if (window.matchMedia('(max-width: 767px)')
		.matches) {
		isMobile = true;
		isDesktop = false;
	} else {
		isMobile = false;
		isDesktop = true;
	}
	/**
	 * To set up a watcher
	 */
	// window.matchMedia('(min-width: 992px)')
	// 	.addEventListener("change", () => {
	// 		if (window.matchMedia('(max-width: 767px)')
	// 			.matches) {
	// 			isMobile = true;
	// 			isDesktop = false;
	// 		} else {
	// 			isMobile = false;
	// 			isDesktop = true;
	// 		}
	// 	})
}
mediaHandler();

new InertiaApp({
	target: app,
	props: {
		initialPage: JSON.parse(app.dataset.page),
		resolveComponent: str => {
			let [section, module] = _.split(str, ',');

			return import(
					/* webpackChunkName: "js/[request]" */
					/* webpackPrefetch: true */
					`../../../${section}/Resources/js/Pages/${module}.svelte`)
				.then(module => module.default)
		},
		transformProps: props => {
			return {
				...props,
				isMobile,
				isDesktop
			}
		}
	},
})

/**
 *! Cause back() and forward() buttons of the browser to refresh the browser state
 */
// if (!('onpopstate' in window)) {
// window.addEventListener('popstate', () => {
// 	Inertia.reload({ preserveScroll: true, preserveState: false })
// })
// }
