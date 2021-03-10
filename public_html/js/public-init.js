(function($) {
	"use strict";

	let passiveSupported = false;

	try {
		const options = Object.defineProperty({}, 'passive', {
			get: function() {
				passiveSupported = true;
			}
		});

		window.addEventListener('test', null, options);
	} catch (err) {}

	let DIRECTION = null;

	function direction() {
		if (DIRECTION === null) {
			DIRECTION = getComputedStyle(document.body)
				.direction;
		}

		return DIRECTION;
	}

	function isRTL() {
		return direction() === 'rtl';
	}

	/*
	// initialize custom numbers
	*/
	$(function() {
		$('.input-number')
			.customNumber();
	});

	/*
	// product tabs
	*/
	$(function() {
		$('.product-tabs')
			.each(function(i, element) {
				$('.product-tabs__list', element)
					.on('click', '.product-tabs__item', function(event) {
						event.preventDefault();

						const tab = $(this);
						const content = $('.product-tabs__pane' + $(this)
							.attr('href'), element);

						if (content.length) {
							$('.product-tabs__item')
								.removeClass('product-tabs__item--active');
							tab.addClass('product-tabs__item--active');

							$('.product-tabs__pane')
								.removeClass('product-tabs__pane--active');
							content.addClass('product-tabs__pane--active');
						}
					});

				const currentTab = $('.product-tabs__item--active', element);
				const firstTab = $('.product-tabs__item:first', element);

				if (currentTab.length) {
					currentTab.trigger('click');
				} else {
					firstTab.trigger('click');
				}
			});
	});

	/*
	// block slideshow
	*/
	$(function() {
		$('.block-slideshow .owl-carousel')
			.owlCarousel({
				items: 1,
				nav: false,
				dots: true,
				loop: true,
				rtl: isRTL()
			});
	});

	/*
	// block brands carousel
	*/
	$(function() {
		$('.block-brands__slider .owl-carousel')
			.owlCarousel({
				nav: false,
				dots: false,
				loop: true,
				rtl: isRTL(),
				responsive: {
					1200: {
						items: 6
					},
					992: {
						items: 5
					},
					768: {
						items: 4
					},
					576: {
						items: 3
					},
					0: {
						items: 2
					}
				}
			});
	});

	/*
	// block posts carousel
	*/
	$(function() {
		$('.block-posts')
			.each(function() {
				const layout = $(this)
					.data('layout');
				const options = {
					margin: 30,
					nav: false,
					dots: false,
					loop: true,
					rtl: isRTL()
				};
				const layoutOptions = {
					'grid-nl': {

						responsive: {
							992: {
								items: 3
							},
							768: {
								items: 2
							},
							0: {
								items: 1
							}
						}
					},
					'list-sm': {
						responsive: {
							992: {
								items: 2
							},
							0: {
								items: 1
							}
						}
					}
				};
				const owl = $('.block-posts__slider .owl-carousel');

				owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

				$(this)
					.find('.block-header__arrow--left')
					.on('click', function() {
						owl.trigger('prev.owl.carousel', [500]);
					});
				$(this)
					.find('.block-header__arrow--right')
					.on('click', function() {
						owl.trigger('next.owl.carousel', [500]);
					});
			});
	});

	/*
	// teammates
	*/
	$(function() {
		$('.teammates .owl-carousel')
			.owlCarousel({
				nav: false,
				dots: true,
				rtl: isRTL(),
				responsive: {
					768: {
						items: 3,
						margin: 32
					},
					380: {
						items: 2,
						margin: 24
					},
					0: {
						items: 1
					}
				}
			});
	});

	/*
	// quickview
	*/
	const quickview = {
		cancelPreviousModal: function() {},
		clickHandler: function() {
			const modal = $('#quickview-modal');
			const button = $(this);
			const doubleClick = button.is('.product-card__quickview--preload');

			quickview.cancelPreviousModal();

			if (doubleClick) {
				return;
			}

			button.addClass('product-card__quickview--preload');

			let xhr = null;
			// timeout ONLY_FOR_DEMO!
			const timeout = setTimeout(function() {
				xhr = $.ajax({
					url: 'quickview.html',
					success: function(data) {
						quickview.cancelPreviousModal = function() {};
						button.removeClass('product-card__quickview--preload');

						modal.find('.modal-content')
							.html(data);
						modal.find('.quickview__close')
							.on('click', function() {
								modal.modal('hide');
							});
						modal.modal('show');
					}
				});
			}, 1000);

			quickview.cancelPreviousModal = function() {
				button.removeClass('product-card__quickview--preload');

				if (xhr) {
					xhr.abort();
				}

				// timeout ONLY_FOR_DEMO!
				clearTimeout(timeout);
			};
		}
	};

	$(function() {
		const modal = $('#quickview-modal');

		modal.on('shown.bs.modal', function() {
			modal.find('.product')
				.each(function() {
					const gallery = $(this)
						.find('.product-gallery');

					if (gallery.length > 0) {
						initProductGallery(gallery[0], $(this)
							.data('layout'));
					}
				});

			$('.input-number', modal)
				.customNumber();
		});

		$('.product-card__quickview')
			.on('click', function() {
				quickview.clickHandler.apply(this, arguments);
			});
	});

	/*
	// products carousel
	*/
	$(function() {
		$('.block-products-carousel')
			.each(function() {
				const layout = $(this)
					.data('layout');
				const options = {
					items: 4,
					margin: 14,
					nav: false,
					dots: false,
					loop: true,
					stagePadding: 1,
					rtl: isRTL()
				};
				const layoutOptions = {
					'grid-4': {
						responsive: {
							1200: {
								items: 4,
								margin: 14
							},
							992: {
								items: 4,
								margin: 10
							},
							768: {
								items: 3,
								margin: 10
							},
							576: {
								items: 2,
								margin: 10
							},
							475: {
								items: 2,
								margin: 10
							},
							0: {
								items: 1
							}
						}
					},
					'grid-4-sm': {
						responsive: {
							1200: {
								items: 4,
								margin: 14
							},
							992: {
								items: 3,
								margin: 10
							},
							768: {
								items: 3,
								margin: 10
							},
							576: {
								items: 2,
								margin: 10
							},
							475: {
								items: 2,
								margin: 10
							},
							0: {
								items: 1
							}
						}
					},
					'grid-5': {
						responsive: {
							1200: {
								items: 5,
								margin: 12
							},
							992: {
								items: 4,
								margin: 10
							},
							768: {
								items: 3,
								margin: 10
							},
							576: {
								items: 2,
								margin: 10
							},
							475: {
								items: 2,
								margin: 10
							},
							0: {
								items: 1
							}
						}
					},
					'horizontal': {
						items: 3,
						responsive: {
							1200: {
								items: 3,
								margin: 14
							},
							992: {
								items: 3,
								margin: 10
							},
							768: {
								items: 2,
								margin: 10
							},
							576: {
								items: 1
							},
							475: {
								items: 1
							},
							0: {
								items: 1
							}
						}
					},
				};
				const owl = $('.owl-carousel', this);
				let cancelPreviousTabChange = function() {};

				owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

				$(this)
					.find('.block-header__group')
					.on('click', function(event) {
						const block = $(this)
							.closest('.block-products-carousel');

						event.preventDefault();

						if ($(this)
							.is('.block-header__group--active')) {
							return;
						}

						cancelPreviousTabChange();

						block.addClass('block-products-carousel--loading');
						$(this)
							.closest('.block-header__groups-list')
							.find('.block-header__group--active')
							.removeClass('block-header__group--active');
						$(this)
							.addClass('block-header__group--active');

						// timeout ONLY_FOR_DEMO! you can replace it with an ajax request
						let timer;
						timer = setTimeout(function() {
							let items = block.find(
								'.owl-carousel .owl-item:not(".cloned") .block-products-carousel__column');

							/*** this is ONLY_FOR_DEMO! / start */
							/**/
							const itemsArray = items.get();
							/**/
							const newItemsArray = [];
							/**/
							/**/
							while (itemsArray.length > 0) {
								/**/
								const randomIndex = Math.floor(Math.random() * itemsArray.length);
								/**/
								const randomItem = itemsArray.splice(randomIndex, 1)[0];
								/**/
								/**/
								newItemsArray.push(randomItem);
								/**/
							}
							/**/
							items = $(newItemsArray);
							/*** this is ONLY_FOR_DEMO! / end */

							block.find('.owl-carousel')
								.trigger('replace.owl.carousel', [items])
								.trigger('refresh.owl.carousel')
								.trigger('to.owl.carousel', [0, 0]);

							$('.product-card__quickview', block)
								.on('click', function() {
									quickview.clickHandler.apply(this, arguments);
								});

							block.removeClass('block-products-carousel--loading');
						}, 1000);
						cancelPreviousTabChange = function() {
							// timeout ONLY_FOR_DEMO!
							clearTimeout(timer);
							cancelPreviousTabChange = function() {};
						};
					});

				$(this)
					.find('.block-header__arrow--left')
					.on('click', function() {
						owl.trigger('prev.owl.carousel', [500]);
					});
				$(this)
					.find('.block-header__arrow--right')
					.on('click', function() {
						owl.trigger('next.owl.carousel', [500]);
					});
			});
	});

	/*
	// product gallery
	*/
	const initProductGallery = function(element, layout) {
		layout = layout !== undefined ? layout : 'standard';

		const options = {
			dots: false,
			margin: 10,
			rtl: isRTL()
		};
		const layoutOptions = {
			standard: {
				responsive: {
					1200: {
						items: 5
					},
					992: {
						items: 4
					},
					768: {
						items: 3
					},
					480: {
						items: 5
					},
					380: {
						items: 4
					},
					0: {
						items: 3
					}
				}
			},
			sidebar: {
				responsive: {
					768: {
						items: 4
					},
					480: {
						items: 5
					},
					380: {
						items: 4
					},
					0: {
						items: 3
					}
				}
			},
			columnar: {
				responsive: {
					768: {
						items: 4
					},
					480: {
						items: 5
					},
					380: {
						items: 4
					},
					0: {
						items: 3
					}
				}
			},
			quickview: {
				responsive: {
					1200: {
						items: 5
					},
					768: {
						items: 4
					},
					480: {
						items: 5
					},
					380: {
						items: 4
					},
					0: {
						items: 3
					}
				}
			}
		};

		const gallery = $(element);

		const image = gallery.find('.product-gallery__featured .owl-carousel');
		const carousel = gallery.find('.product-gallery__carousel .owl-carousel');

		image
			.owlCarousel({
				items: 1,
				dots: false,
				rtl: isRTL()
			})
			.on('changed.owl.carousel', syncPosition);

		carousel
			.on('initialized.owl.carousel', function() {
				carousel.find('.product-gallery__carousel-item')
					.eq(0)
					.addClass('product-gallery__carousel-item--active');
			})
			.owlCarousel($.extend({}, options, layoutOptions[layout]));

		carousel.on('click', '.owl-item', function(e) {
			e.preventDefault();

			image.data('owl.carousel')
				.to($(this)
					.index(), 300, true);
		});

		gallery.find('.product-gallery__zoom')
			.on('click', function() {
				openPhotoSwipe(image.find('.owl-item.active')
					.index());
			});

		image.on('click', '.owl-item > a', function(event) {
			event.preventDefault();

			openPhotoSwipe($(this)
				.closest('.owl-item')
				.index());
		});

		function getIndexDependOnDir(index) {
			// we need to invert index id direction === 'rtl' because photoswipe do not support rtl
			if (isRTL()) {
				return image.find('.owl-item img')
					.length - 1 - index;
			}

			return index;
		}

		function openPhotoSwipe(index) {
			const photoSwipeImages = image.find('.owl-item > a')
				.toArray()
				.map(function(element) {
					return {
						src: element.href,
						msrc: element.href,
						w: 700,
						h: 700
					};
				});

			if (isRTL()) {
				photoSwipeImages.reverse();
			}

			const photoSwipeOptions = {
				getThumbBoundsFn: function(index) {
					const imageElements = image.find('.owl-item img')
						.toArray();
					const dirDependentIndex = getIndexDependOnDir(index);

					if (!imageElements[dirDependentIndex]) {
						return null;
					}

					const imageElement = imageElements[dirDependentIndex];
					const pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
					const rect = imageElement.getBoundingClientRect();

					return {
						x: rect.left,
						y: rect.top + pageYScroll,
						w: rect.width
					};
				},
				index: getIndexDependOnDir(index),
				bgOpacity: .9,
				history: false
			};

			const photoSwipeGallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, photoSwipeImages,
				photoSwipeOptions);

			photoSwipeGallery.listen('beforeChange', function() {
				image.data('owl.carousel')
					.to(getIndexDependOnDir(photoSwipeGallery.getCurrentIndex()), 0, true);
			});

			photoSwipeGallery.init();
		}

		function syncPosition(el) {
			let current = el.item.index;

			carousel
				.find('.product-gallery__carousel-item')
				.removeClass('product-gallery__carousel-item--active')
				.eq(current)
				.addClass('product-gallery__carousel-item--active');
			const onscreen = carousel.find('.owl-item.active')
				.length - 1;
			const start = carousel.find('.owl-item.active')
				.first()
				.index();
			const end = carousel.find('.owl-item.active')
				.last()
				.index();

			if (current > end) {
				carousel.data('owl.carousel')
					.to(current, 100, true);
			}
			if (current < start) {
				carousel.data('owl.carousel')
					.to(current - onscreen, 100, true);
			}
		}
	};

	$(function() {
		$('.product')
			.each(function() {
				const gallery = $(this)
					.find('.product-gallery');

				if (gallery.length > 0) {
					initProductGallery(gallery[0], $(this)
						.data('layout'));
				}
			});
	});

	/*
	// Checkout payment methods
	*/
	$(function() {
		$('[name="checkout_payment_method"]')
			.on('change', function() {
				const currentItem = $(this)
					.closest('.payment-methods__item');

				$(this)
					.closest('.payment-methods__list')
					.find('.payment-methods__item')
					.each(function(i, element) {
						const links = $(element);
						const linksContent = links.find('.payment-methods__item-container');

						if (element !== currentItem[0]) {
							const startHeight = linksContent.height();

							linksContent.css('height', startHeight + 'px');
							links.removeClass('payment-methods__item--active');
							linksContent.height(); // force reflow

							linksContent.css('height', '');
						} else {
							const startHeight = linksContent.height();

							links.addClass('payment-methods__item--active');

							const endHeight = linksContent.height();

							linksContent.css('height', startHeight + 'px');
							linksContent.height(); // force reflow
							linksContent.css('height', endHeight + 'px');
						}
					});
			});

		$('.payment-methods__item-container')
			.on('transitionend', function(event) {
				if (event.originalEvent.propertyName === 'height') {
					$(this)
						.css('height', '');
				}
			});
	});

	/*
	// collapse
	*/
	$(function() {
		$('[data-collapse]')
			.each(function(i, element) {
				const collapse = element;

				$('[data-collapse-trigger]', collapse)
					.on('click', function() {
						const openedClass = $(this)
							.closest('[data-collapse-opened-class]')
							.data('collapse-opened-class');
						const item = $(this)
							.closest('[data-collapse-item]');
						const content = item.children('[data-collapse-content]');
						const itemParents = item.parents();

						itemParents.slice(0, itemParents.index(collapse) + 1)
							.filter('[data-collapse-item]')
							.css('height', '');

						if (item.is('.' + openedClass)) {
							const startHeight = content.height();

							content.css('height', startHeight + 'px');
							item.removeClass(openedClass);

							content.height(); // force reflow
							content.css('height', '');
						} else {
							const startHeight = content.height();

							item.addClass(openedClass);

							const endHeight = content.height();

							content.css('height', startHeight + 'px');
							content.height(); // force reflow
							content.css('height', endHeight + 'px');
						}
					});

				$('[data-collapse-content]', collapse)
					.on('transitionend', function(event) {
						if (event.originalEvent.propertyName === 'height') {
							$(this)
								.css('height', '');
						}
					});
			});
	});

	/*
	// price filter
	*/
	$(function() {
		$('.filter-price')
			.each(function(i, element) {
				const min = $(element)
					.data('min');
				const max = $(element)
					.data('max');
				const from = $(element)
					.data('from');
				const to = $(element)
					.data('to');
				const slider = element.querySelector('.filter-price__slider');

				noUiSlider.create(slider, {
					start: [from, to],
					connect: true,
					direction: isRTL() ? 'rtl' : 'ltr',
					range: {
						'min': min,
						'max': max
					}
				});

				const titleValues = [
                $(element)
					.find('.filter-price__min-value')[0],
                $(element)
					.find('.filter-price__max-value')[0]
            ];

				slider.noUiSlider.on('update', function(values, handle) {
					titleValues[handle].innerHTML = values[handle];
				});
			});
	});

	/*
	// mobilemenu
	*/
	$(function() {
		const body = $('body');
		const mobilemenu = $('.mobilemenu');

		if (mobilemenu.length) {
			const open = function() {
				const bodyWidth = body.width();
				body.css('overflow', 'hidden');
				body.css('paddingRight', (body.width() - bodyWidth) + 'px');

				mobilemenu.addClass('mobilemenu--open');
			};
			const close = function() {
				body.css('overflow', '');
				body.css('paddingRight', '');

				mobilemenu.removeClass('mobilemenu--open');
			};

			$('.mobile-header__menu-button')
				.on('click', function() {
					open();
				});
			$('.mobilemenu__backdrop, .mobilemenu__close')
				.on('click', function() {
					close();
				});
		}
	});

	/*
	// tooltips
	*/
	$(function() {
		$('[data-toggle="tooltip"]')
			.tooltip({
				trigger: 'hover'
			});
	});

	/*
	// layout switcher
	*/
	$(function() {
		$('.layout-switcher__button')
			.on('click', function() {
				const layoutSwitcher = $(this)
					.closest('.layout-switcher');
				const productsView = $(this)
					.closest('.products-view');
				const productsList = productsView.find('.products-list');

				layoutSwitcher.find('.layout-switcher__button')
					.removeClass('layout-switcher__button--active');
				$(this)
					.addClass('layout-switcher__button--active');

				productsList.attr('data-layout', $(this)
					.attr('data-layout'));
				productsList.attr('data-with-features', $(this)
					.attr('data-with-features'));
			});
	});

	/*
	// offcanvas filters
	*/
	$(function() {
		const body = $('body');
		const blockSidebar = $('.block-sidebar');
		const mobileMedia = matchMedia('(max-width: 991px)');

		if (blockSidebar.length) {
			const open = function() {
				if (blockSidebar.is('.block-sidebar--offcanvas--mobile') && !mobileMedia.matches) {
					return;
				}

				const bodyWidth = body.width();
				body.css('overflow', 'hidden');
				body.css('paddingRight', (body.width() - bodyWidth) + 'px');

				blockSidebar.addClass('block-sidebar--open');
			};
			const close = function() {
				body.css('overflow', '');
				body.css('paddingRight', '');

				blockSidebar.removeClass('block-sidebar--open');
			};
			const onChangeMedia = function() {
				if (blockSidebar.is('.block-sidebar--open.block-sidebar--offcanvas--mobile') && !mobileMedia.matches) {
					close();
				}
			};

			$('.filters-button')
				.on('click', function() {
					open();
				});
			$('.block-sidebar__backdrop, .block-sidebar__close')
				.on('click', function() {
					close();
				});

			if (mobileMedia.addEventListener) {
				mobileMedia.addEventListener('change', onChangeMedia);
			} else {
				mobileMedia.addListener(onChangeMedia);
			}
		}
	});

	/*
	// .block-finder
	*/
	$(function() {
		$('.block-finder__select')
			.on('change', function() {
				const item = $(this)
					.closest('.block-finder__form-item');

				if ($(this)
					.val() !== 'none') {
					item.find('~ .block-finder__form-item:eq(0) .block-finder__select')
						.prop('disabled', false)
						.val('none');
					item.find('~ .block-finder__form-item:gt(0) .block-finder__select')
						.prop('disabled', true)
						.val('none');
				} else {
					item.find('~ .block-finder__form-item .block-finder__select')
						.prop('disabled', true)
						.val('none');
				}

				item.find('~ .block-finder__form-item .block-finder__select')
					.trigger('change.select2');
			});
	});

	/*
	// select2
	*/
	$(function() {
		$('.form-control-select2, .block-finder__select')
			.select2({
				width: ''
			});
	});

	/*
	// totop
	*/
	$(function() {
		let show = false;

		$('.totop__button')
			.on('click', function() {
				$('html, body')
					.animate({
						scrollTop: 0
					}, '300');
			});

		let fixedPositionStart = 300;

		window.addEventListener('scroll', function() {
			if (window.pageYOffset >= fixedPositionStart) {
				if (!show) {
					show = true;
					$('.totop')
						.addClass('totop--show');
				}
			} else {
				if (show) {
					show = false;
					$('.totop')
						.removeClass('totop--show');
				}
			}
		}, passiveSupported ? {
			passive: true
		} : false);
	});
})(jQuery);

(function($) {
    "use strict";

    let passiveSupported = false;

    try {
        const options = Object.defineProperty({}, 'passive', {
            get: function() {
                passiveSupported = true;
            }
        });

        window.addEventListener('test', null, options);
    } catch (err) {}

    let DIRECTION = null;

    function direction() {
        if (DIRECTION === null) {
            DIRECTION = getComputedStyle(document.body).direction;
        }

        return DIRECTION;
    }

    function isRTL() {
        return direction() === 'rtl';
    }

    $(function() {
        /*
        // Touch Click
        */
        function touchClick(elements, callback) {
            elements = $(elements);

            let touchStartData = null;

            const onTouchstart = function(event) {
                const originalEvent = event.originalEvent;

                if (originalEvent.touches.length !== 1) {
                    touchStartData = null;
                    return;
                }

                touchStartData = {
                    target: originalEvent.currentTarget,
                    touch: originalEvent.changedTouches[0],
                    timestamp: (new Date).getTime(),
                };
            };
            const onTouchEnd = function(event) {
                const originalEvent = event.originalEvent;

                if (!touchStartData ||
                    originalEvent.changedTouches.length !== 1 ||
                    originalEvent.changedTouches[0].identity !== touchStartData.touch.identity
                ) {
                    return;
                }

                const timestamp = (new Date).getTime();
                const touch = originalEvent.changedTouches[0];
                const distance = Math.abs(
                    Math.sqrt(
                        Math.pow(touchStartData.touch.screenX - touch.screenX, 2) +
                        Math.pow(touchStartData.touch.screenY - touch.screenY, 2)
                    )
                );

                if (touchStartData.target === originalEvent.currentTarget && timestamp - touchStartData.timestamp < 500 && distance < 10) {
                    callback(event);
                }
            };

            elements.on('touchstart', onTouchstart);
            elements.on('touchend', onTouchEnd);

            return function() {
                elements.off('touchstart', onTouchstart);
                elements.off('touchend', onTouchEnd);
            };
        }

        // call this in touchstart/touchend event handler
        function preventTouchClick() {
            const onClick = function(event) {
                event.preventDefault();

                document.removeEventListener('click', onClick);
            };
            document.addEventListener('click', onClick);
            setTimeout(function() {
                document.removeEventListener('click', onClick);
            }, 100);
        }


        /*
        // topbar dropdown
        */
        $('.topbar-dropdown__btn').on('click', function() {
            $(this).closest('.topbar-dropdown').toggleClass('topbar-dropdown--opened');
        });

        document.addEventListener('click', function(event) {
            $('.topbar-dropdown')
                .not($(event.target).closest('.topbar-dropdown'))
                .removeClass('topbar-dropdown--opened');
        }, true);

        touchClick(document, function(event) {
            $('.topbar-dropdown')
                .not($(event.target).closest('.topbar-dropdown'))
                .removeClass('topbar-dropdown--opened');
        });


        /*
        // search suggestions
        */
        $('.search').each(function(index, element) {
            let xhr;
            const search = $(element);
            const input = search.find('.search__input');
            const suggestions = search.find('.search__suggestions');
            const outsideClick = function(event) {
                // If the inner element still has focus, ignore the click.
                if ($(document.activeElement).closest('.search').is(search)) {
                    return;
                }

                search
                    .not($(event.target).closest('.search'))
                    .removeClass('search--suggestions-open');
            };
            const setSuggestion = function(html) {
                if (html) {
                    suggestions.html(html);
                }
                search.toggleClass('search--has-suggestions', !!html);
            };

            search.on('focusout', function() {
                setTimeout(function() {
                    if (document.activeElement === document.body) {
                        return;
                    }

                    // Close suggestions if the focus received an external element.
                    search
                        .not($(document.activeElement).closest('.search'))
                        .removeClass('search--suggestions-open');
                }, 10);
            });
            input.on('input', function() {
                if (xhr) {
                    // Abort previous AJAX request.
                    xhr.abort();
                }

                if (input.val()) {
                    // YOUR AJAX REQUEST HERE.
                    xhr = $.ajax({
                        url: 'suggestions.html',
                        success: function(data) {
                            xhr = null;
                            setSuggestion(data);
                        }
                    });
                } else {
                    // Remove suggestions.
                    setSuggestion('');
                }
            });
            input.on('focus', function() {
                search.addClass('search--suggestions-open');
            });

            document.addEventListener('click', outsideClick, true);
            touchClick(document, outsideClick);

            if (input.is(document.activeElement)) {
                input.trigger('focus').trigger('input');
            }
        });


        /*
        // mobile search
        */
        const mobileSearch = $('.mobile-header__search');

        if (mobileSearch.length) {
            $('.indicator--mobile-search .indicator__button').on('click', function() {
                if (mobileSearch.is('.mobile-header__search--open')) {
                    mobileSearch.removeClass('mobile-header__search--open');
                } else {
                    mobileSearch.addClass('mobile-header__search--open');
                    mobileSearch.find('input')[0].focus();
                }
            });

            mobileSearch.find('.search__button--type--close').on('click', function() {
                mobileSearch.removeClass('mobile-header__search--open');
            });

            document.addEventListener('click', function(event) {
                if (!$(event.target).closest('.indicator--mobile-search, .mobile-header__search').length) {
                    mobileSearch.removeClass('mobile-header__search--open');
                }
            }, true);
        }


        /*
        // nav-links
        */
        function CNavLinks(element) {
            this.element = $(element);
            this.items = this.element.find('.nav-links__item');
            this.currentItem = null;

            this.element.data('navLinksInstance', this);

            this.onMouseenter = this.onMouseenter.bind(this);
            this.onMouseleave = this.onMouseleave.bind(this);
            this.onGlobalTouchClick = this.onGlobalTouchClick.bind(this);
            this.onTouchClick = this.onTouchClick.bind(this);

            // add event listeners
            this.items.on('mouseenter', this.onMouseenter);
            this.items.on('mouseleave', this.onMouseleave);
            touchClick(document, this.onGlobalTouchClick);
            touchClick(this.items, this.onTouchClick);
        }
        CNavLinks.prototype.onGlobalTouchClick = function(event) {
            // check that the click was outside the element
            if (this.element.not($(event.target).closest('.nav-links')).length) {
                this.unsetCurrentItem();
            }
        };
        CNavLinks.prototype.onTouchClick = function(event) {
            if (event.cancelable) {
                const targetItem = $(event.currentTarget);

                if (this.currentItem && this.currentItem.is(targetItem)) {
                    return;
                }

                if (this.hasSubmenu(targetItem)) {
                    event.preventDefault();

                    if (this.currentItem) {
                        this.currentItem.trigger('mouseleave');
                    }

                    targetItem.trigger('mouseenter');
                }
            }
        };
        CNavLinks.prototype.onMouseenter = function(event) {
            this.setCurrentItem($(event.currentTarget));
        };
        CNavLinks.prototype.onMouseleave = function() {
            this.unsetCurrentItem();
        };
        CNavLinks.prototype.setCurrentItem = function(item) {
            this.currentItem = item;
            this.currentItem.addClass('nav-links__item--hover');

            this.openSubmenu(this.currentItem);
        };
        CNavLinks.prototype.unsetCurrentItem = function() {
            if (this.currentItem) {
                this.closeSubmenu(this.currentItem);

                this.currentItem.removeClass('nav-links__item--hover');
                this.currentItem = null;
            }
        };
        CNavLinks.prototype.hasSubmenu = function(item) {
            return !!item.children('.nav-links__submenu').length;
        };
        CNavLinks.prototype.openSubmenu = function(item) {
            const submenu = item.children('.nav-links__submenu');

            if (!submenu.length) {
                return;
            }

            submenu.addClass('nav-links__submenu--display');

            // calculate max height
            const submenuTop = submenu.offset().top - $(window).scrollTop();
            const viewportHeight = window.innerHeight;
            const paddingBottom = 20;

            submenu.css('maxHeight', (viewportHeight - submenuTop - paddingBottom) + 'px');
            submenu.addClass('nav-links__submenu--open');

            // megamenu position
            if (submenu.hasClass('nav-links__submenu--type--megamenu')) {
                const container = submenu.offsetParent();
                const containerWidth = container.width();
                const megamenuWidth = submenu.width();

                if (isRTL()) {
                    const itemPosition = containerWidth - (item.position().left + item.width());
                    const megamenuPosition = Math.round(Math.min(itemPosition, containerWidth - megamenuWidth));

                    submenu.css('right', megamenuPosition + 'px');
                } else {
                    const itemPosition = item.position().left;
                    const megamenuPosition = Math.round(Math.min(itemPosition, containerWidth - megamenuWidth));

                    submenu.css('left', megamenuPosition + 'px');
                }
            }
        };
        CNavLinks.prototype.closeSubmenu = function(item) {
            const submenu = item.children('.nav-links__submenu');

            if (!submenu.length) {
                return;
            }

            submenu.removeClass('nav-links__submenu--display');
            submenu.removeClass('nav-links__submenu--open');
            submenu.css('maxHeight', '');

            if (submenu && submenu.is('.nav-links__submenu--type--menu')) {
                const submenuInstance = submenu.find('> .menu').data('menuInstance');

                if (submenuInstance) {
                    submenuInstance.unsetCurrentItem();
                }
            }
        };

        $('.nav-links').each(function() {
            new CNavLinks(this);
        });


        /*
        // menu
        */
        function CMenu(element) {
            this.element = $(element);
            this.container = this.element.find('> .menu__submenus-container');
            this.items = this.element.find('> .menu__list > .menu__item');
            this.currentItem = null;

            this.element.data('menuInstance', this);

            this.onMouseenter = this.onMouseenter.bind(this);
            this.onMouseleave = this.onMouseleave.bind(this);
            this.onTouchClick = this.onTouchClick.bind(this);

            // add event listeners
            this.items.on('mouseenter', this.onMouseenter);
            this.element.on('mouseleave', this.onMouseleave);
            touchClick(this.items, this.onTouchClick);
        }
        CMenu.prototype.onMouseenter = function(event) {
            const targetItem = $(event.currentTarget);

            if (this.currentItem && targetItem.is(this.currentItem)) {
                return;
            }

            this.unsetCurrentItem();
            this.setCurrentItem(targetItem);
        };
        CMenu.prototype.onMouseleave = function() {
            this.unsetCurrentItem();
        };
        CMenu.prototype.onTouchClick = function(event) {
            const targetItem = $(event.currentTarget);

            if (this.currentItem && this.currentItem.is(targetItem)) {
                return;
            }

            if (this.hasSubmenu(targetItem)) {
                preventTouchClick();

                this.unsetCurrentItem();
                this.setCurrentItem(targetItem);
            }
        };
        CMenu.prototype.setCurrentItem = function(item) {
            this.currentItem = item;
            this.currentItem.addClass('menu__item--hover');

            this.openSubmenu(this.currentItem);
        };
        CMenu.prototype.unsetCurrentItem = function() {
            if (this.currentItem) {
                this.closeSubmenu(this.currentItem);

                this.currentItem.removeClass('menu__item--hover');
                this.currentItem = null;
            }
        };
        CMenu.prototype.getSubmenu = function(item) {
            let submenu = item.find('> .menu__submenu');

            if (submenu.length) {
                this.container.append(submenu);
                item.data('submenu', submenu);
            }

            return item.data('submenu');
        };
        CMenu.prototype.hasSubmenu = function(item) {
            return !!this.getSubmenu(item);
        };
        CMenu.prototype.openSubmenu = function(item) {
            const submenu = this.getSubmenu(item);

            if (!submenu) {
                return;
            }

            submenu.addClass('menu__submenu--display');

            // calc submenu position
            const menuTop = this.element.offset().top - $(window).scrollTop();
            const itemTop = item.find('> .menu__item-submenu-offset').offset().top - $(window).scrollTop();
            const viewportHeight = window.innerHeight;
            const paddingY = 20;
            const maxHeight = viewportHeight - paddingY * 2;

            submenu.css('maxHeight', maxHeight + 'px');

            const submenuHeight = submenu.height();
            const position = Math.min(
                Math.max(
                    itemTop - menuTop,
                    0
                ),
                (viewportHeight - paddingY - submenuHeight) - menuTop
            );

            submenu.css('top', position + 'px');
            submenu.addClass('menu__submenu--open');

            if (isRTL()) {
                const submenuLeft = this.element.offset().left - submenu.width();

                if (submenuLeft < 0) {
                    submenu.addClass('menu__submenu--reverse');
                }
            } else {
                const submenuRight = this.element.offset().left + this.element.width() + submenu.width();

                if (submenuRight > $('body').innerWidth()) {
                    submenu.addClass('menu__submenu--reverse');
                }
            }
        };
        CMenu.prototype.closeSubmenu = function(item) {
            const submenu = this.getSubmenu(item);

            if (submenu) {
                submenu.removeClass('menu__submenu--display');
                submenu.removeClass('menu__submenu--open');
                submenu.removeClass('menu__submenu--reverse');

                const submenuInstance = submenu.find('> .menu').data('menuInstance');

                if (submenuInstance) {
                    submenuInstance.unsetCurrentItem();
                }
            }
        };
        $('.menu').each(function() {
            new CMenu($(this));
        });


        /*
        // indicator (dropcart, drop search)
        */
        function CIndicator(element) {
            this.element = $(element);
            this.dropdown = this.element.find('.indicator__dropdown');
            this.button = this.element.find('.indicator__button');
            this.trigger = null;

            this.element.data('indicatorInstance', this);

            if (this.element.hasClass('indicator--trigger--hover')) {
                this.trigger = 'hover';
            } else if (this.element.hasClass('indicator--trigger--click')) {
                this.trigger = 'click';
            }

            this.onMouseenter = this.onMouseenter.bind(this);
            this.onMouseleave = this.onMouseleave.bind(this);
            this.onTransitionend = this.onTransitionend.bind(this);
            this.onClick = this.onClick.bind(this);
            this.onGlobalClick = this.onGlobalClick.bind(this);

            // add event listeners
            this.element.on('mouseenter', this.onMouseenter);
            this.element.on('mouseleave', this.onMouseleave);
            this.dropdown.on('transitionend', this.onTransitionend);
            this.button.on('click', this.onClick);
            $(document).on('click', this.onGlobalClick);
            touchClick(document, this.onGlobalClick);

            this.element.find('.search__input').on('keydown', function(event) {
                const ESC_KEY_CODE = 27;

                if (event.which === ESC_KEY_CODE) {
                    const instance = $(this).closest('.indicator').data('indicatorInstance');

                    if (instance) {
                        instance.close();
                    }
                }
            });
        }
        CIndicator.prototype.toggle = function() {
            if (this.isOpen()) {
                this.close();
            } else {
                this.open();
            }
        };
        CIndicator.prototype.onMouseenter = function() {
            this.element.addClass('indicator--hover');

            if (this.trigger === 'hover') {
                this.open();
            }
        };
        CIndicator.prototype.onMouseleave = function() {
            this.element.removeClass('indicator--hover');

            if (this.trigger === 'hover') {
                this.close();
            }
        };
        CIndicator.prototype.onTransitionend = function(event) {
            if (
                this.dropdown.is(event.target) &&
                event.originalEvent.propertyName === 'visibility' &&
                !this.isOpen()
            ) {
                this.element.removeClass('indicator--display');
            }
        };
        CIndicator.prototype.onClick = function(event) {
            if (this.trigger !== 'click') {
                return;
            }

            if (event.cancelable) {
                event.preventDefault();
            }

            this.toggle();
        };
        CIndicator.prototype.onGlobalClick = function(event) {
            // check that the click was outside the element
            if (this.element.not($(event.target).closest('.indicator')).length) {
                this.close();
            }
        };
        CIndicator.prototype.isOpen = function() {
            return this.element.is('.indicator--open');
        };
        CIndicator.prototype.open = function() {
            this.element.addClass('indicator--display');
            this.element.width(); // force reflow
            this.element.addClass('indicator--open');
            this.element.find('.search__input').focus();

            const dropdownTop = this.dropdown.offset().top - $(window).scrollTop();
            const viewportHeight = window.innerHeight;
            const paddingBottom = 20;

            this.dropdown.css('maxHeight', (viewportHeight - dropdownTop - paddingBottom) + 'px');
        };
        CIndicator.prototype.close = function() {
            this.element.removeClass('indicator--open');
        };
        CIndicator.prototype.closeImmediately = function() {
            this.element.removeClass('indicator--open');
            this.element.removeClass('indicator--display');
        };

        $('.indicator').each(function() {
            new CIndicator(this);
        });


        /*
        // departments, sticky header
        */
        $(function() {
            /*
            // departments
            */
            const CDepartments = function(element) {
                const self = this;

                element.data('departmentsInstance', self);

                this.element = element;
                this.container = this.element.find('.departments__submenus-container');
                this.linksWrapper = this.element.find('.departments__links-wrapper');
                this.body = this.element.find('.departments__body');
                this.button = this.element.find('.departments__button');
                this.items = this.element.find('.departments__item');
                this.mode = this.element.is('.departments--fixed') ? 'fixed' : 'normal';
                this.fixedBy = $(this.element.data('departments-fixed-by'));
                this.fixedHeight = 0;
                this.currentItem = null;

                if (this.mode === 'fixed' && this.fixedBy.length) {
                    this.fixedHeight = this.fixedBy.offset().top - this.body.offset().top + this.fixedBy.outerHeight();
                    this.body.css('height', this.fixedHeight + 'px');
                }

                this.linksWrapper.on('transitionend', function(event) {
                    if (event.originalEvent.propertyName === 'height') {
                        $(this).css('height', '');
                        $(this).closest('.departments').removeClass('departments--transition');
                    }
                });

                this.onButtonClick = this.onButtonClick.bind(this);
                this.onGlobalClick = this.onGlobalClick.bind(this);
                this.onMouseenter = this.onMouseenter.bind(this);
                this.onMouseleave = this.onMouseleave.bind(this);
                this.onTouchClick = this.onTouchClick.bind(this);

                // add event listeners
                this.button.on('click', this.onButtonClick);
                document.addEventListener('click', this.onGlobalClick, true);
                touchClick(document, this.onGlobalClick);
                this.items.on('mouseenter', this.onMouseenter);
                this.linksWrapper.on('mouseleave', this.onMouseleave);
                touchClick(this.items, this.onTouchClick);

            };
            CDepartments.prototype.onButtonClick = function(event) {
                event.preventDefault();

                if (this.element.is('.departments--open')) {
                    this.close();
                } else {
                    this.open();
                }
            };
            CDepartments.prototype.onGlobalClick = function(event) {
                if (this.element.not($(event.target).closest('.departments')).length) {
                    if (this.element.is('.departments--open')) {
                        this.close();
                    }
                }
            };
            CDepartments.prototype.setMode = function(mode) {
                this.mode = mode;

                if (this.mode === 'normal') {
                    this.element.removeClass('departments--fixed');
                    this.element.removeClass('departments--open');
                    this.body.css('height', 'auto');
                }
                if (this.mode === 'fixed') {
                    this.element.addClass('departments--fixed');
                    this.element.addClass('departments--open');
                    this.body.css('height', this.fixedHeight + 'px');
                    $('.departments__links-wrapper', this.element).css('maxHeight', '');
                }
            };
            CDepartments.prototype.close = function() {
                if (this.element.is('.departments--fixed')) {
                    return;
                }

                const content = this.element.find('.departments__links-wrapper');
                const startHeight = content.height();

                content.css('height', startHeight + 'px');
                this.element
                    .addClass('departments--transition')
                    .removeClass('departments--open');

                content.height(); // force reflow
                content.css('height', '');
                content.css('maxHeight', '');

                this.unsetCurrentItem();
            };
            CDepartments.prototype.closeImmediately = function() {
                if (this.element.is('.departments--fixed')) {
                    return;
                }

                const content = this.element.find('.departments__links-wrapper');

                this.element.removeClass('departments--open');

                content.css('height', '');
                content.css('maxHeight', '');

                this.unsetCurrentItem();
            };
            CDepartments.prototype.open = function() {
                const content = this.element.find('.departments__links-wrapper');
                const startHeight = content.height();

                this.element
                    .addClass('departments--transition')
                    .addClass('departments--open');

                const documentHeight = document.documentElement.clientHeight;
                const paddingBottom = 20;
                const contentRect = content[0].getBoundingClientRect();
                const endHeight = Math.min(content.height(), documentHeight - paddingBottom - contentRect.top);

                content.css('height', startHeight + 'px');
                content.height(); // force reflow
                content.css('maxHeight', endHeight + 'px');
                content.css('height', endHeight + 'px');
            };
            CDepartments.prototype.onMouseenter = function(event) {
                const targetItem = $(event.currentTarget);

                if (this.currentItem && targetItem.is(this.currentItem)) {
                    return;
                }

                this.unsetCurrentItem();
                this.setCurrentItem(targetItem);
            };
            CDepartments.prototype.onMouseleave = function() {
                this.unsetCurrentItem();
            };
            CDepartments.prototype.onTouchClick = function(event) {
                const targetItem = $(event.currentTarget);

                if (this.currentItem && this.currentItem.is(targetItem)) {
                    return;
                }

                if (this.hasSubmenu(targetItem)) {
                    preventTouchClick();

                    this.unsetCurrentItem();
                    this.setCurrentItem(targetItem);
                }
            };
            CDepartments.prototype.setCurrentItem = function(item) {
                this.unsetCurrentItem();

                this.currentItem = item;
                this.currentItem.addClass('departments__item--hover');

                this.openSubmenu(this.currentItem);
            };
            CDepartments.prototype.unsetCurrentItem = function() {
                if (this.currentItem) {
                    this.closeSubmenu(this.currentItem);

                    this.currentItem.removeClass('departments__item--hover');
                    this.currentItem = null;
                }
            };
            CDepartments.prototype.getSubmenu = function(item) {
                let submenu = item.find('> .departments__submenu');

                if (submenu.length) {
                    this.container.append(submenu);

                    item.data('submenu', submenu);
                }

                return item.data('submenu');
            };
            CDepartments.prototype.hasSubmenu = function(item) {
                return !!this.getSubmenu(item);
            };
            CDepartments.prototype.openSubmenu = function(item) {
                const submenu = this.getSubmenu(item);

                if (submenu) {
                    submenu.addClass('departments__submenu--open');

                    const documentHeight = document.documentElement.clientHeight;
                    const paddingBottom = 20;

                    if (submenu.hasClass('departments__submenu--type--megamenu')) {
                        const submenuTop = submenu.offset().top - $(window).scrollTop();
                        submenu.css('maxHeight', (documentHeight - submenuTop - paddingBottom) + 'px');
                    }

                    if (submenu.hasClass('departments__submenu--type--menu')) {
                        submenu.css('maxHeight', (documentHeight - paddingBottom - Math.min(
                            paddingBottom,
                            this.body.offset().top - $(window).scrollTop()
                        )) + 'px');

                        const submenuHeight = submenu.height();
                        const itemTop = this.currentItem.offset().top - $(window).scrollTop();
                        const containerTop = this.container.offset().top - $(window).scrollTop();

                        submenu.css('top', (Math.min(itemTop, documentHeight - paddingBottom - submenuHeight) - containerTop) + 'px');
                    }
                }
            };
            CDepartments.prototype.closeSubmenu = function(item) {
                const submenu = item.data('submenu');

                if (submenu) {
                    submenu.removeClass('departments__submenu--open');

                    if (submenu.is('.departments__submenu--type--menu')) {
                        submenu.find('> .menu').data('menuInstance').unsetCurrentItem();
                    }
                }
            };

            const departmentsElement = $('.departments');
            const departments = departmentsElement.length ? new CDepartments(departmentsElement) : null;


            /*
            // sticky nav-panel
            */
            const nav = $('.nav-panel--sticky');

            if (nav.length) {
                const mode = nav.data('sticky-mode') ? nav.data('sticky-mode') : 'alwaysOnTop'; // one of [alwaysOnTop, pullToShow]
                const media = matchMedia('(min-width: 992px)');
                const departmentsMode = departments ? departments.mode : null;

                let stuck = false;
                let shown = false;
                let scrollDistance = 0;
                let scrollPosition = 0;
                let positionWhenToFix = function() {
                    return 0;
                };
                let positionWhenToStick = function() {
                    return 0;
                };

                const closeAllSubmenus = function() {
                    if (departments) {
                        departments.closeImmediately();
                    }
                    $('.nav-links').data('navLinksInstance').unsetCurrentItem();
                    $('.indicator').each(function() {
                        $(this).data('indicatorInstance').closeImmediately();
                    });
                };

                const onScroll = function() {
                    const scrollDelta = window.pageYOffset - scrollPosition;

                    if ((scrollDelta < 0) !== (scrollDistance < 0)) {
                        scrollDistance = 0;
                    }

                    scrollPosition = window.pageYOffset;
                    scrollDistance += scrollDelta;

                    if (window.pageYOffset > positionWhenToStick()) {
                        if (!stuck) {
                            nav.addClass('nav-panel--stuck');
                            nav.css('transitionDuration', '0s');

                            if (mode === 'alwaysOnTop') {
                                nav.addClass('nav-panel--show');
                                shown = true;
                            }

                            nav.height(); // force reflow
                            nav.css('transitionDuration', '');
                            stuck = true;

                            if (departments && departmentsMode === 'fixed') {
                                departments.setMode('normal');
                            }

                            closeAllSubmenus();
                        }

                        if (mode === 'pullToShow') {
                            const distanceToShow = 10; // in pixels
                            const distanceToHide = 25; // in pixels

                            if (scrollDistance < -distanceToShow && !nav.hasClass('nav-panel--show')) {
                                nav.addClass('nav-panel--show');
                                shown = true;
                            }
                            if (scrollDistance > distanceToHide && nav.hasClass('nav-panel--show')) {
                                nav.removeClass('nav-panel--show');
                                shown = false;

                                closeAllSubmenus();
                            }
                        }
                    } else if (window.pageYOffset <= positionWhenToFix()) {
                        if (stuck) {
                            nav.removeClass('nav-panel--stuck');
                            nav.removeClass('nav-panel--show');
                            stuck = false;
                            shown = false;

                            if (departments && departmentsMode === 'fixed') {
                                departments.setMode('fixed');
                            }

                            closeAllSubmenus();
                        }
                    }
                };

                const onMediaChange = function() {
                    if (media.matches) {
                        scrollDistance = 0;
                        scrollPosition = window.pageYOffset;

                        const navPanelTop = nav.offset().top;
                        const navPanelBottom = navPanelTop + nav.outerHeight();
                        const departmentsBottom = departments ? departments.body.offset().top + departments.body.outerHeight() : 0;

                        if (departments && departmentsMode === 'fixed' && departmentsBottom > navPanelBottom) {
                            positionWhenToFix = positionWhenToStick = function() {
                                return departmentsBottom;
                            };
                        } else {
                            if (mode === 'alwaysOnTop') {
                                positionWhenToFix = positionWhenToStick = function() {
                                    return navPanelTop;
                                };
                            } else {
                                positionWhenToFix = function() {
                                    return shown ? navPanelTop : navPanelBottom;
                                };
                                positionWhenToStick = function() {
                                    return navPanelBottom;
                                };
                            }
                        }

                        window.addEventListener('scroll', onScroll, passiveSupported ? {
                            passive: true
                        } : false);

                        onScroll();
                    } else {
                        if (stuck) {
                            nav.removeClass('nav-panel--stuck');
                            nav.removeClass('nav-panel--show');
                            stuck = false;
                            shown = false;

                            if (departments && departmentsMode === 'fixed') {
                                departments.setMode('fixed');
                            }

                            closeAllSubmenus();
                        }

                        window.removeEventListener('scroll', onScroll, passiveSupported ? {
                            passive: true
                        } : false);
                    }
                };

                if (media.addEventListener) {
                    media.addEventListener('change', onMediaChange);
                } else {
                    media.addListener(onMediaChange);
                }

                onMediaChange();
            }


            /*
            // sticky mobile-header
            */
            const mobileHeader = $('.mobile-header--sticky');
            const mobileHeaderPanel = mobileHeader.find('.mobile-header__panel');

            if (mobileHeader.length) {
                const mode = mobileHeader.data('sticky-mode') ? mobileHeader.data('sticky-mode') : 'alwaysOnTop'; // one of [alwaysOnTop, pullToShow]
                const media = matchMedia('(min-width: 992px)');

                let stuck = false;
                let shown = false;
                let scrollDistance = 0;
                let scrollPosition = 0;
                let positionWhenToFix = 0;
                let positionWhenToStick = 0;

                const onScroll = function() {
                    const scrollDelta = window.pageYOffset - scrollPosition;

                    if ((scrollDelta < 0) !== (scrollDistance < 0)) {
                        scrollDistance = 0;
                    }

                    scrollPosition = window.pageYOffset;
                    scrollDistance += scrollDelta;

                    if (window.pageYOffset > positionWhenToStick) {
                        if (!stuck) {
                            mobileHeader.addClass('mobile-header--stuck');
                            mobileHeaderPanel.css('transitionDuration', '0s');

                            if (mode === 'alwaysOnTop') {
                                mobileHeader.addClass('mobile-header--show');
                                shown = true;
                            }

                            mobileHeader.height(); // force reflow
                            mobileHeaderPanel.css('transitionDuration', '');
                            stuck = true;
                        }

                        if (mode === 'pullToShow') {
                            if (window.pageYOffset > positionWhenToFix) {
                                const distanceToShow = 10; // in pixels
                                const distanceToHide = 25; // in pixels

                                if (scrollDistance < -distanceToShow && !shown) {
                                    mobileHeader.addClass('mobile-header--show');
                                    shown = true;
                                }
                                if (scrollDistance > distanceToHide && shown) {
                                    mobileHeader.removeClass('mobile-header--show');
                                    shown = false;
                                }
                            } else if (shown) {
                                mobileHeader.removeClass('mobile-header--show');
                                shown = false;
                            }
                        }
                    } else if (window.pageYOffset <= positionWhenToFix) {
                        if (stuck) {
                            mobileHeader.removeClass('mobile-header--stuck');
                            mobileHeader.removeClass('mobile-header--show');
                            stuck = false;
                            shown = false;
                        }
                    }
                };

                const onMediaChange = function() {
                    if (!media.matches) {
                        scrollDistance = 0;
                        scrollPosition = window.pageYOffset;
                        positionWhenToFix = mobileHeader.offset().top;
                        positionWhenToStick = positionWhenToFix + (mode === 'alwaysOnTop' ? 0 : mobileHeader.outerHeight());

                        window.addEventListener('scroll', onScroll, passiveSupported ? {
                            passive: true
                        } : false);

                        onScroll();
                    } else {
                        if (stuck) {
                            mobileHeader.removeClass('mobile-header--stuck');
                            mobileHeader.removeClass('mobile-header--show');
                            stuck = false;
                            shown = false;
                        }

                        window.removeEventListener('scroll', onScroll, passiveSupported ? {
                            passive: true
                        } : false);
                    }
                };

                if (media.addEventListener) {
                    media.addEventListener('change', onMediaChange);
                } else {
                    media.addListener(onMediaChange);
                }

                onMediaChange();
            }
        });


        /*
        // offcanvas cart
        */
        (function() {
            const body = $('body');
            const cart = $('.dropcart--style--offcanvas');

            if (cart.length === 0) {
                return;
            }

            function cartIsHidden() {
                return window.getComputedStyle(cart[0]).visibility === 'hidden';
            }

            function showScrollbar() {
                body.css('overflow', '');
                body.css('paddingRight', '');
            }

            function hideScrollbar() {
                const bodyWidth = body.width();
                body.css('overflow', 'hidden');
                body.css('paddingRight', (body.width() - bodyWidth) + 'px');
            }

            function open() {
                hideScrollbar();

                cart.addClass('dropcart--open');
            }

            function close() {
                if (cartIsHidden()) {
                    showScrollbar();
                }

                cart.removeClass('dropcart--open');
            }

            $('[data-open="offcanvas-cart"]').on('click', function(event) {
                if (!event.cancelable) {
                    return;
                }

                event.preventDefault();

                open();
            });

            cart.find('.dropcart__backdrop, .dropcart__close').on('click', function() {
                close();
            });

            cart.on('transitionend', function(event) {
                if (cart.is(event.target) && event.originalEvent.propertyName === 'visibility' && cartIsHidden()) {
                    showScrollbar();
                }
            });
        })();
    });

})(jQuery);