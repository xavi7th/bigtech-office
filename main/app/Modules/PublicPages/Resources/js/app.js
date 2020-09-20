import "@public-assets/sass/app.scss";
import '@public-assets/js/bootstrap'
// import {
// 	InertiaApp
// } from '@inertiajs/inertia-svelte'

// const app = document.getElementById('app')
// let isMobile, isDesktop;

// let mediaHandler = () => {
// 	if (window.matchMedia('(max-width: 767px)')
// 		.matches) {
// 		isMobile = true;
// 		isDesktop = false;
// 	} else {
// 		isMobile = false;
// 		isDesktop = true;
// 	}
// 	/**
// 	 * To set up a watcher
// 	 */
// 	// window.matchMedia( '(min-width: 992px)' ).addEventListener( "change", () => {
// 	// 	console.log( 'changed' )
// 	// } )
// }
// mediaHandler();

// new InertiaApp({
// 	target: app,
// 	props: {
// 		initialPage: JSON.parse(app.dataset.page),
// 		resolveComponent: str => {
// 			let [section, module] = _.split(str, ',');

// 			return import(
// 					/* webpackChunkName: "js/[request]" */
// 					/* webpackPrefetch: true */
// 					`../../../${section}/Resources/js/Pages/${module}.svelte`)
// 				.then(module => module.default)
// 		},
// 		transformProps: props => {
// 			return {
// 				...props,
// 				isMobile,
// 				isDesktop
// 			}
// 		}
// 	},
// })
