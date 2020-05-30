/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Svelte and other libraries. It is a great starting point when
 * building robust, powerful web applications using Svelte and Laravel.
 */

import '@public-assets/js/bootstrap'

import {
	InertiaApp
} from '@inertiajs/inertia-svelte'

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
	// window.matchMedia( '(min-width: 992px)' ).addEventListener( "change", () => {
	// 	console.log( 'changed' )
	// } )
}
mediaHandler();

new InertiaApp({
	target: app,
	props: {
		initialPage: JSON.parse(app.dataset.page),
		resolveComponent: name => import( /* webpackChunkName: "js/public" */ `./Pages/${name}.svelte`)
			.then(module => module.default),
		transformProps: props => {
			return {
				...props,
				isMobile,
				isDesktop
			}
		}
	},
})
