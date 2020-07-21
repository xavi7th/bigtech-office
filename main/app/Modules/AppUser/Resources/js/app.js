import "@user-assets/sass/app.scss";
import '@public-assets/js/bootstrap'

import {
	InertiaApp
} from '@inertiajs/inertia-svelte'

const app = document.getElementById('app')

new InertiaApp({
	target: app,
	props: {
		initialPage: JSON.parse(app.dataset.page),
		resolveComponent: name => import(
				/* webpackChunkName: "js/[request]" */
				/* webpackPrefetch: true */
				`./Pages/${name}.svelte`)
			.then(module => module.default),
	},
})
