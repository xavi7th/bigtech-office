/*!
 * Name: RootUI - Dashboards and Administration areas for React + Redux and HTML
 * Version: 1.1.2
 * Author: dexad, nK
 * Website: https://nkdev.info/
 * Purchase: https://themeforest.net/user/_nk/portfolio
 * Support: https://nk.ticksy.com/
 * License: You must have a valid license purchased only from ThemeForest (the above link) in order to legally use the theme for your project.
 * Copyright 2019.
 */
! function(t) {
	var e = {};

	function n(i) {
		if (e[i]) return e[i].exports;
		var a = e[i] = {
			i: i,
			l: !1,
			exports: {}
		};
		return t[i].call(a.exports, a, a.exports, n), a.l = !0, a.exports
	}
	n.m = t, n.c = e, n.d = function(t, e, i) {
		n.o(t, e) || Object.defineProperty(t, e, {
			enumerable: !0,
			get: i
		})
	}, n.r = function(t) {
		"undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
			value: "Module"
		}), Object.defineProperty(t, "__esModule", {
			value: !0
		})
	}, n.t = function(t, e) {
		if (1 & e && (t = n(t)), 8 & e) return t;
		if (4 & e && "object" == typeof t && t && t.__esModule) return t;
		var i = Object.create(null);
		if (n.r(i), Object.defineProperty(i, "default", {
				enumerable: !0,
				value: t
			}), 2 & e && "string" != typeof t)
			for (var a in t) n.d(i, a, function(e) {
				return t[e]
			}.bind(null, a));
		return i
	}, n.n = function(t) {
		var e = t && t.__esModule ? function() {
			return t.default
		} : function() {
			return t
		};
		return n.d(e, "a", e), e
	}, n.o = function(t, e) {
		return Object.prototype.hasOwnProperty.call(t, e)
	}, n.p = "", n(n.s = 6)
}({
	0: function(t, e, n) {
		"use strict";
		n.d(e, "a", (function() {
			return i
		}));
		var i = {
			ajax: !0,
			events: {
				onBeforeAjax: function() {
					return !1
				},
				onAfterAjax: function() {}
			}
		}
	},
	6: function(t, e, n) {
		"use strict";
		n.r(e);
		var i = n(0),
			a = window.jQuery,
			o = (window.TweenMax, /iPad|iPhone|iPod/.test(window.navigator.userAgent) && window.MSStream,
				/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/g.test(window.navigator.userAgent || window.navigator
					.vendor || window.opera));
		"ontouchstart" in window || window.DocumentTouch && (document, window.DocumentTouch);
a("html")
	.addClass(o ? "is-mobile" : "is-desktop");
		var r = a(window),
			s = a(document),
			l = a(".main-page-wrap"),
			u = 0,
			c = 0,
			d = 0;

		function h() {
			u = r.outerWidth(), c = r.height(), d = s.height()
		}
h(), r.on("resize load orientationchange", h);
		var p, f = [];

		function g() {
			clearTimeout(p), p = setTimeout((function() {
				if (f.length)
					for (var t = 0; t < f.length; t++) f[t]()
			}), 50)
		}

		function v(t) {
			"function" == typeof t ? f.push(t) : window.dispatchEvent(new window.Event("resize"))
		}
		r.on("ready load resize orientationchange", g), g();
		var m, w, y, b, k, C = [],
			x = 0;

		function P() {
			var t = r.scrollTop(),
				e = "";
			e = t > x ? "down" : t < x ? "up" : "none", 0 === t ? e = "start" : t >= d - c && (e = "end"), C.forEach((
				function(n) {
					"function" == typeof n && n(e, t, x, r)
				})), x = t
		}

		function S(t) {
			C.push(t)
		}

		function j() {
			var t = window.innerWidth;
			if (!t) {
				var e = document.documentElement.getBoundingClientRect();
				t = e.right - Math.abs(e.left)
			}
			y = l[0].clientWidth < t, b = function() {
				var t = document.createElement("div");
				t.className = "rui-body-scrollbar-measure", l[0].appendChild(t);
				var e = t.offsetWidth - t.clientWidth;
				return l[0].removeChild(t), e
			}()
		}

		function T(t) {
			t && !w ? (w = 1, j(), b && (void 0 === k && (k = l.css("padding-right") || ""), y && l.add(a(
					".rui-navbar-mobile"))
				.css("paddingRight", "".concat(b, "px"))), l.css("overflow", "hidden")) : !t && w && (w = 0, l.css(
				"overflow", ""), b && (l.css("paddingRight", k), a(".rui-navbar-mobile")
				.css("paddingRight", "")))
		}

		function z(t, e) {
			var n = t[0].getBoundingClientRect(),
				i = 1;
			if (n.right <= 0 || n.left >= u) i = 0;
			else if (n.bottom < 0 && n.top <= c) i = 0;
			else {
				var a = Math.max(0, n.height + n.top),
					o = Math.max(0, n.height - (n.top + n.height - c)),
					r = Math.max(0, -n.top),
					s = Math.max(0, n.top + n.height - c);
				n.height < c ? i = 1 - (r || s) / n.height : a <= c ? i = a / c : o <= c && (i = o / c), i = i < 0 ? 0 : i
			}
			return e ? [i, n] : i
		}

		function I(t) {
			var e = a.extend({}, this.options.templates, t && t.templates || {}),
				n = a.extend({}, this.options.events, t && t.events || {});
			this.options = a.extend({}, this.options, t), this.options.templates = e, this.options.events = n
		}
		function R() {
			var t = this,
				e = a("html");
			t.isNightMode = function() {
				return e.hasClass('rui-nightmode')
			}, t.toggleNightMode = function() {
				var n = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
					i = a("input.rui-nightmode-toggle");
				switch (n || (n = t.isNightMode() ? "day" : "night"), n) {
					case "night":
						e.addClass("rui-nightmode"), i.prop("checked", !0);
						break;
					case "day":
						e.removeClass("rui-nightmode"), i.prop("checked", !1)
				}
				a("[data-src-".concat(n, "]"))
					.each((function() {
						var t = a(this);
						t.attr("src", t.attr("data-src-".concat(n)))
					}))
			};
			var n = t.isNightMode() ? "night" : "day";
			t.toggleNightMode(n), s.on("change", "input.rui-nightmode-toggle", (function() {
				t.toggleNightMode()
			}))
		}

		function A() {
			var t = this,
				e = a(".rui-navbar"),
				n = a(".rui-navbar-top"),
				i = l.filter(".rui-navbar-autohide");
			i.length && t.throttleScroll((function(t, e) {
				"down" === t && e > 400 ? i.removeClass("rui-navbar-show")
					.addClass("rui-navbar-hide") : "up" !== t && "end" !== t && "start" !== t || i.removeClass(
						"rui-navbar-hide")
					.addClass("rui-navbar-show")
			}));
			var o = a(".rui-navbar-mobile"),
				r = o.find(".rui-navbar-collapse");

			function u() {
				if (!t.isNightMode()) {
					a("input.rui-darkNavbar-toggle")
						.prop("checked", e.hasClass("rui-navbar-dark"));
					var n = "";
					n = e.hasClass("rui-navbar-dark") ? "night" : "day", a(".rui-navbar [data-src-".concat(n, "]"))
						.each((function() {
							var t = a(this);
							t.attr("src", t.attr("data-src-".concat(n)))
						}))
				}
			}
			s.on("show.bs.collapse hide.bs.collapse", ".rui-navbar-collapse", (function(t) {
				"show" === t.type && (o.addClass("rui-navbar-show"), T(1)), "hide" === t.type && (o.removeClass(
					"rui-navbar-show"), T(0))
			})), s.on("keyup", (function(t) {
				27 === t.keyCode && r.hasClass("show") && r.collapse && r.collapse("hide")
			})), s.on("click", ".rui-navbar-bg", (function() {
				r.collapse && r.collapse("hide")
			})), (n.hasClass("rui-navbar-fixed") || n.hasClass("rui-navbar-sticky")) && S((function(t, e) {
				e > 200 ? n.addClass("rui-navbar-scroll") : n.removeClass("rui-navbar-scroll")
			})), u(), s.on("change", "input.rui-darkNavbar-toggle", (function() {
				e.toggleClass("rui-navbar-dark"), u()
			}))
		}

		function M() {
			function t() {
				a(".dropdown:not(.rui-dropdown-triangle-ready)")
					.addClass("rui-dropdown-triangle-ready")
					.each((function() {
						var t = a(this),
							e = t.children(".dropdown-menu");
						t.hasClass("dropdown-triangle") && e.append('<span class="dropdown-menu-triangle"></span>')
					}))
			}
			s.on("mouseenter mouseleave", ".dropdown.dropdown-hover", (function(t) {
				var e = a(this);
				"mouseenter" === t.type && (e.children(".dropdown-item")
					.dropdown("toggle"), e.parents(".dropdown-hover")
					.length && e.parents(".dropdown-menu")
					.dropdown("show")), "mouseleave" === t.type && (e.children(".dropdown-item")
					.dropdown("toggle"), e.parents(".dropdown-hover")
					.length && e.parents(".dropdown-menu")
					.dropdown("show"))
			})), s.on("show.bs.dropdown", ".dropdown", (function() {
				var t = a(this),
					e = t.children(".dropdown-menu");
				t.hasClass("dropdown-hover") ? (t.addClass("hover"), e.addClass("hover")) : (t.addClass("focus"), e
					.addClass("focus"))
			})), s.on("hidden.bs.dropdown", ".dropdown", (function() {
				var t = a(this),
					e = t.children(".dropdown-menu");
				t.hasClass("dropdown-hover") ? (t.removeClass("hover"), e.removeClass("hover")) : (t.removeClass(
					"focus"), e.removeClass("focus")), t.hasClass("dropdown-autoposition") && (t.removeClass(
						"dropdown-autoposition"), t.children(".dropdown-item")
					.dropdown("dispose"))
			})), s.on("shown.bs.dropdown", ".dropdown", (function() {
				var t = a(this),
					e = t.children(".dropdown-menu"),
					n = t.children(".dropdown-item"),
					i = e.children(".dropdown-menu-triangle");
				e.css("margin-left", ""), i.css("margin-left", ""), e.offset()
					.left + e.outerWidth() > u && (t.addClass("dropdown-autoposition"), n.dropdown("update"), e.css(
						"margin-left", (e.offset()
							.left + e.outerWidth() - (u - 27)) / -1), i.length && i.css("margin-left", n.offset()
						.left - i.offset()
						.left + (n.outerWidth() / 2 - i.outerWidth() / 2))), setTimeout((function() {
						t.parents(".dropdown-hover")
							.length && (e.attr("x-placement", "right-start")
								.css({
									transform: "",
									left: "",
									top: ""
								}), e.offset()
								.top + e.outerHeight() > c && e.attr("x-placement", "right-end"), e.offset()
								.left + e.outerWidth() > u && (e.attr("x-placement", "left-start"), e.offset()
									.top + e.outerHeight() > c && e.attr("x-placement", "left-end")))
					}), 10)
			})), s.on("click", ".dropdown-keep-open .dropdown-menu", (function(t) {
				t.stopPropagation()
			})), t()
		}

		function _() {
			function t() {
				a(".rui-messenger:not(.rui-messenger-ready)")
					.addClass("rui-messenger-ready")
					.each((function() {
						var t = a(this),
							e = t.find(".rui-messenger-chat");

						function n() {
							var t = e.find(".rui-messenger-body"),
								n = e.find(".os-viewport");
							if (n.length) {
								var i = n.find(".os-content")
									.innerHeight() - n.innerHeight();
								n.scrollTop(i)
							} else {
								var a = t.add("> div")
									.innerHeight() - t.innerHeight();
								t.scrollTop(a)
							}
						}

						function i(t) {
							void 0 !== window.emojione && t.each((function() {
								var t = a(this);
								t.html(window.emojione.toImage(t.html()))
							}))
						}

						function o() {
							var a = t.find(".rui-messenger-textarea")
								.data("emojioneArea");
							if (a) {
								var o = e.find(".rui-messenger-message:last"),
									r = o.find(".rui-messenger-message-time")
									.text(),
									s = e.find(".rui-messenger-message-structure"),
									l = a.getText();
								if (l && s.length) {
									var u = new Date,
										c = u.getHours(),
										d = u.getMinutes();
									c < 10 && (c = "0".concat(c)), d < 10 && (d = "0".concat(d));
									var h = "".concat(c, ":")
										.concat(d);
									r === h ? o.find("ul > li:last")
										.after("<li></li>")
										.next() : (o.after(s.clone()), (o = e.find(".rui-messenger-message:last"))
											.removeClass("rui-messenger-message-structure"), o.find(".rui-messenger-message-time")
											.text(h));
									var p = o.find("ul > li:last");
									p.html(l), i(p), n(), a.setText("")
								}
							}
						}
						setTimeout((function() {
								n()
							}), 100), t.hasClass("rui-messenger-mini") && s.on("afterClose.fb", (function() {
								t.removeClass("open show"), e.removeClass("open show")
							})), i(t.find(".rui-messenger-message li")), e.find(".rui-messenger-send")
							.on("click", (function(t) {
								t.preventDefault(), o()
							})), t.on("keyup", (function(t) {
								13 === t.keyCode && o()
							}))
					}))
			}
			t(), s.on("click", ".rui-messenger-item, .rui-messenger-back", (function(t) {
				t.preventDefault();
				var e = a(this),
					n = e.closest(".rui-messenger"),
					i = n.find(".rui-messenger-chat");
				if (e.hasClass("rui-messenger-item")) {
					var o = i.find(".rui-messenger-body"),
						r = i.find(".os-viewport");
					if (n.addClass("open show"), i.addClass("open show"), r.length) {
						var s = r.find(".os-content"),
							l = s.innerHeight() - r.innerHeight();
						r.scrollTop(l), s.css("border-right") && r.find(".os-content")
							.css("border-right", "")
					} else {
						var u = o.add("> div")
							.innerHeight() - o.innerHeight();
						o.scrollTop(u)
					}
				}
				e.hasClass("rui-messenger-back") && (n.removeClass("open"), i.removeClass("open"), setTimeout((
					function() {
						n.removeClass("show"), i.removeClass("show")
					}), 150))
			}))
		}

		function E() {
			s.on("click", ".rui-mailbox-item, .rui-mailbox-content-back", (function(t) {
				t.preventDefault();
				var e = a(this),
					n = e.closest(".rui-mailbox"),
					i = n.find(".rui-mailbox-content");
				e.hasClass("rui-mailbox-item") && (n.addClass("open show"), i.addClass("open show")), e.hasClass(
					"rui-mailbox-content-back") && (n.removeClass("open"), i.removeClass("open"), setTimeout((
					function() {
						n.removeClass("show"), i.removeClass("show")
					}), 150))
			}))
		}

		function U() {
			function t(t, e) {
				t.css({
					width: e.innerWidth(),
					height: e.outerHeight(),
					transform: "translate(".concat(e.position()
							.left, "px, ")
						.concat(e.position()
							.top, "px)")
				})
			}

			function e() {
				a(".rui-tabs-sliding:not(.rui-tabs-sliding-ready)")
					.addClass("rui-tabs-sliding-ready")
					.each((function() {
						var e = a(this),
							n = a('<li class="rui-tabs-slide"></li>'),
							i = e.find(".rui-tabs-link.active");
						e.prepend(n), i.length && t(n, i)
					}))
			}
			e(), s.on("click", ".rui-tabs-link", (function(e) {
				e.preventDefault();
				var n = a(this),
					i = n.closest(".rui-tabs-sliding")
					.find(".rui-tabs-slide");
				n.length && t(i, n)
			}))
		}

		function O() {
			function t() {
				a("input.rui-spotlightmode-toggle")
					.prop("checked", l.hasClass("rui-spotlightmode"))
			}
			t(), s.on("change", "input.rui-spotlightmode-toggle", (function() {
				l.toggleClass("rui-spotlightmode"), t()
			}))
		}

		function W() {
			function t() {
				a("input.rui-sectionLines-toggle")
					.prop("checked", l.hasClass("rui-section-lines"))
			}
			t(), s.on("change", "input.rui-sectionLines-toggle", (function() {
				l.toggleClass("rui-section-lines"), t()
			}))
		}
		r.on("scroll load resize orientationchange", (function() {
				C.length && (m = !0)
			})),
			setInterval((function() {
				m && (m = !1, window.requestAnimationFrame(P))
			}), 250);
		var H = {
			dropdown_toggle_transition: 200,
			sidebar_toggle_transition: 250,
			resizeWnd: 1200,
			resizeSmallWnd: 576,
			closeSiblings: !0,
			closeChilds: !0,
			gestures: !0,
			menuWrapSelector: ".yay-wrap-menu",
			contentSelector: ".content-wrap",
			toggleSelector: ".yay-toggle",
			submenuSelector: ".yay-submenu",
			submenuToggleSelector: ".yay-sub-toggle",
			htmlOverflowClass: "yay-html-overflow",
			rtlClass: "yay-rtl",
			hideClass: "yay-hide",
			effectOverlayClass: "yay-overlay",
			effectPushClass: "yay-push",
			effectShrinkClass: "yay-shrink",
			overlapContentClass: "yay-content-overlay",
			staticPositionClass: "yay-static",
			submenuOpenClass: "yay-submenu-open"
		};

		function Y() {
			if (void 0 !== window.YAYBAR) {
				var t = a(".yaybar"),
					e = H.effectShrinkClass,
					n = H.effectPushClass,
					i = H.effectOverlayClass;
				t.each((function() {
					var s = new window.YAYBAR,
						c = a(this),
						d = c.find(".yay-submenu");
					c.data("yaybar", s), s.setOptions(H), s.init(c), d.hasClass("dropdown-triangle") && d.append(
						'<span class="dropdown-menu-triangle"></span>'), l.hasClass("yay-hide") && o(), l.hasClass(
						"rui-spotlightmode") && o(), c.on("show.yaybar hide.yaybar", (function(t) {
						c.hasClass(i) ? ("show" === t.type && T(1), "hide" === t.type && T(0)) : T(0)
					}));
					var h = "",
						p = !1;

					function f() {
						!p && u < H.resizeSmallWnd ? (c.removeClass("yay-hide-to-small"), p = !0, setTimeout(v, 100)) :
							p && u >= H.resizeSmallWnd && (c.addClass("yay-hide-to-small"), p = !1, setTimeout(v, 100)), u <
							H.resizeWnd ? h || (h = t.hasClass(e) ? e : t.hasClass(n) ? n : !t.hasClass(i) || i, c
								.removeClass("".concat(e, " ")
									.concat(n))
								.addClass(i), o()) : h && (h !== i && (c.removeClass("".concat(e, " ")
									.concat(n, " ")
									.concat(i))
								.addClass(h), t.data("yaybar")
								.showYay()), h = "")
					}
					u < H.resizeWnd && f(), r.on("ready load resize orientationchange", f)
				})), s.on("show.bs.collapse", ".rui-navbar-collapse", (function() {
					o()
				})), s.on("change", "input.rui-spotlightmode-toggle", (function() {
					l.hasClass("rui-spotlightmode") && o()
				})), s.on("change", "input.rui-darkSidebar-toggle", (function() {
					t.toggleClass("rui-yaybar-dark")
				})), c(), s.on("change", "input.rui-staticSidebar-toggle", (function() {
					t.toggleClass("yay-static"), c()
				}));
				$('.rui-yaybar-toggle ')
					.on('click', function() {
						$('.main-page-wrap')
							.toggleClass('yay-hide')
					});
				$('.rui-yaybar-bg ')
					.on('click', function() {
						$('.main-page-wrap')
							.addClass('yay-hide')
					});
			}

			function o() {
				t.data("yaybar")
					.hideYay()
			}

			function c() {
				a("input.rui-staticSidebar-toggle")
					.prop("checked", t.hasClass("yay-static"))
			}
		}

		function N() {
			void 0 !== a.fn.overlayScrollbars && a(".rui-scrollbar:not(.rui-scrollbar-ready)")
				.addClass("rui-scrollbar-ready")
				.overlayScrollbars({
					scrollbars: {
						clickScrolling: !0
					}
				})
		}
		function q() {
			void 0 !== window.feather && window.feather.replace()
		}
		function at() {
			"undefined" != typeof Swiper && a(".rui-swiper:not(.rui-swiper-ready")
				.addClass("rui-swiper-ready")
				.each((function() {
					var t = a(this),
						e = t.find(".swiper-container"),
						n = t.find(".swiper-button-prev"),
						i = t.find(".swiper-button-next"),
						o = t.attr("data-swiper-initialSlide"),
						r = "true" === t.attr("data-swiper-loop"),
						s = "true" === t.attr("data-swiper-grabCursor"),
						l = "true" === t.attr("data-swiper-center"),
						c = t.attr("data-swiper-autoHeight"),
						d = t.attr("data-swiper-breakpoints"),
						h = parseInt(t.attr("data-swiper-autoplay"), 10),
						p = parseInt(t.attr("data-swiper-speed"), 10),
						f = t.attr("data-swiper-slides"),
						g = parseInt(t.attr("data-swiper-gap"), 10),
						v = {
							keyboard: {
								enabled: !0
							}
						};
					if (n.length && i.length && (v.navigation = {
							nextEl: i[0],
							prevEl: n[0]
						}), o && (v.initialSlide = parseInt(o, 10) || 0), r && (v.loop = !0), s && (v.grabCursor = !0), l &&
						(v.centeredSlides = !0), c && (v.autoHeight = !0), h && (v.autoplay = {
							delay: h
						}), p && (v.speed = p), v.slidesPerView = "auto" === f ? f : parseInt(f, 10), g && (v.spaceBetween =
							g), d) {
						for (var m = 0, w = {}, y = d.split(","); m < d.split(",")
							.length;) w[parseInt(y[m].split(":")[0], 10)] = {
							slidesPerView: parseInt(y[m].split(":")[1], 10)
						}, m++;
						v.breakpoints = w
					}
					var b = new Swiper(e[0], v),
						k = a(".yaybar"),
						C = k.data("yaybar")
						.options.resizeWnd;
					k.on("showed.yaybar hidden.yaybar", (function() {
						u > C && b.update()
					})), u < C && k.one("showed.yaybar hidden.yaybar", (function() {
						b.update()
					}))
				}))
		}
		function ct(t, e) {
			for (var n = 0; n < e.length; n++) {
				var i = e[n];
				i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object
					.defineProperty(t, i.key, i)
			}
		}
		var dt = function() {
			function t() {
				! function(t, e) {
					if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
				}(this, t), this.options = i.a
			}
			var e, n, a;
			return e = t, (n = [{
				key: "init",
				value: function() {
					return this.initNightMode(), this.initNavbar(), this.initDropdown(), this.initMessenger(),
						this.initMailbox(), this.initTabsSliding(), this.initSpotlightMode(), this.initSectionLines(),
						this.initPluginYaybar(), this.initPluginOverlayScrollbars(), this.initPluginFeather(),
						this.initPluginHightlight(), this
				}
            }, {
				key: "setOptions",
				value: function(t) {
					return I.call(this, t)
				}
            }, {
				key: "debounceResize",
				value: function(t) {
					return v.call(this, t)
				}
            }, {
				key: "throttleScroll",
				value: function(t) {
					return S.call(this, t)
				}
            }, {
				key: "bodyOverflow",
				value: function(t) {
					return T.call(this, t)
				}
            }, {
				key: "isInViewport",
				value: function(t, e) {
					return z.call(this, t, e)
				}
            }, {
				key: "initNavbar",
				value: function() {
					return A.call(this)
				}
            }, {
				key: "initDropdown",
				value: function() {
					return M.call(this)
				}
            }, {
				key: "initMessenger",
				value: function() {
					// console.log('initMessenger disabled by dev');
					return;
					// return _.call(this)
				}
            }, {
				key: "initMailbox",
				value: function() {
					// console.log('initMailbox disabled by dev');
					return;
					// return E.call(this)
				}
            }, {
				key: "initTabsSliding",
				value: function() {
					return U.call(this)
				}
            }, {
				key: "initNightMode",
				value: function() {
					return R.call(this)
				}
            }, {
				key: "initSpotlightMode",
				value: function() {
					return O.call(this)
				}
            }, {
				key: "initSectionLines",
				value: function() {
					return W.call(this)
				}
            }, {
				key: "initPluginYaybar",
				value: function() {
					return Y.call(this)
				}
            }, {
				key: "initPluginOverlayScrollbars",
				value: function() {
					return N.call(this)
				}
            }, {
				key: "initPluginFeather",
				value: function(t) {
					return q.call(this, t)
				}
            }, {
				key: "initPluginHightlight",
				value: function() {
					return $.call(this)
				}
            }, {
				key: "initPluginSwiper",
				value: function() {
					return at.call(this)
				}
            }]) && ct(e.prototype, n), a && ct(e, a), t
		}();
		window.RootUI = new dt
	}
});
