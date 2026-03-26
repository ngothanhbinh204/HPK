/**
 * Frontend Scripts for CanhCam Theme
 */



(function($) {
	'use strict';

	$(document).ready(function() {
		initPriceFilter();
		initAjaxFilters();
		initNewsFilter();
		initProductFilter();
	});

	/**
	 * AJAX Filter Products by Category (Home Page)
	 */
	function initProductFilter() {
		const section = $('.home-4');
		if (!section.length) return;

		let home4Swiper;

		const initSwiper = () => {
			if ($('.home-4-swiper').length > 0 && typeof Swiper !== 'undefined') {
				if (home4Swiper) home4Swiper.destroy(true, true);
				home4Swiper = new Swiper(".home-4-swiper", {
					slidesPerView: 1,
					spaceBetween: 10,
					navigation: {
						nextEl: ".home-4 .swiper-button-next",
						prevEl: ".home-4 .swiper-button-prev",
					},
					breakpoints: {
						640: { slidesPerView: 2, spaceBetween: 12 },
						768: { slidesPerView: 3, spaceBetween: 12 },
						1024: { slidesPerView: 4, spaceBetween: 20 },
					},
					autoplay: {
						delay: 5000,
						disableOnInteraction: false,
					},
					observer: true,
					observeParents: true,
				});
			}
		};

		// Initial Call
		initSwiper();

		// Tab Click Event
		$(document).on('click', '.home-4 .tab-item', function(e) {
			const $this = $(this);
			const $section = $this.closest('.home-4');
			const categoryId = $this.attr('data-category-id') || 'all';
			const categoryPool = $section.find('ul').attr('data-category-pool') || '';
			const swiperWrapper = $section.find('.home-4-swiper .swiper-wrapper');
			const loadingOverlay = $section.find('.loading-overlay');

			if ($this.hasClass('active')) return;

			// Update Tab UI
			$('.home-4 .tab-item').removeClass('active');
			$this.addClass('active');

			// Show Loading
			loadingOverlay.addClass('active');

			$.ajax({
				url: canhcam_params.ajax_url,
				type: 'POST',
				data: {
					action: 'filter_products_by_category',
					category_id: categoryId,
					category_pool: categoryPool
				},
				success: function(response) {
					if (response.success) {
						const data = response.data;
						console.log("[DEBUG] Home Filter AJAX Success:", data);
						
						let htmlString = "";
						if (typeof data === 'object' && typeof data.html !== 'undefined') {
							htmlString = data.html;
							console.log(`[DEBUG] Home Category Products Count: ${data.count}`);
						} else {
							htmlString = typeof data === 'string' ? data : '';
						}

						// Use native Swiper API for DOM manipulation if instance is alive
						if (home4Swiper) {
							home4Swiper.removeAllSlides();
							home4Swiper.appendSlide(htmlString);
							home4Swiper.update();
							home4Swiper.slideTo(0);
						} else {
							// Strict jQuery fallback
							const freshWrapper = $section.find('.home-4-swiper .swiper-wrapper');
							freshWrapper.empty().append(htmlString);
							initSwiper();
						}
						
						// Re-init AOS & Lozad
						if (typeof AOS !== 'undefined') AOS.refresh();
						refreshPlugins();
					}
				},
				error: function(err) {
					console.error("Error filtering products:", err);
				},
				complete: function() {
					loadingOverlay.removeClass('active');
				}
			});
		});

	}



	/**
	 * AJAX Filter News by Category (Home Page)
	 */
	function initNewsFilter() {
		const section = $('.home-8');
		if (!section.length) return;

		let home8Swiper;

		const initSwiper = () => {
			// Swiper might be initialized in main.min.js, 
			// so we check if the instance exists or just re-init on the element
			if ($('.home-8-swiper').length > 0 && typeof Swiper !== 'undefined') {
				home8Swiper = new Swiper(".home-8-swiper", {
					slidesPerView: 1,
					spaceBetween: 12,
					navigation: {
						nextEl: ".home-8-next",
						prevEl: ".home-8-prev",
					},
					autoplay: {
						delay: 5000,
						disableOnInteraction: false,
					},
					observer: true,
					observeParents: true,
				});
			}
		};

		// Tab Click Event
		$(document).on('click', '.home-8 .tab-item', function(e) {
			const $this = $(this);
			const categoryId = $this.data('category-id') || 'all';
			const swiperWrapper = section.find('.swiper-wrapper');
			const loadingOverlay = section.find('.loading-overlay');

			if ($this.hasClass('active')) return;

			// Update Tab UI
			$('.home-8 .tab-item').removeClass('active');
			$this.addClass('active');

			// Show Loading
			loadingOverlay.addClass('active');

			$.ajax({
				url: canhcam_params.ajax_url,
				type: 'POST',
				data: {
					action: 'filter_news_by_category',
					category_id: categoryId
				},
				success: function(response) {
					if (response.success) {
						swiperWrapper.html(response.data);
						initSwiper();
						
						// Re-init AOS
						if (typeof AOS !== 'undefined') {
							AOS.refresh();
						}
					}
				},
				error: function(err) {
					console.error("Error filtering news:", err);
				},
				complete: function() {
					loadingOverlay.removeClass('active');
				}
			});
		});
	}


	/**
	 * AJAX Full Filtering & Load More
	 */
	function initAjaxFilters() {
		const productList = $('#product-list-section');
		if (!productList.length || productList.data('ajax-filter') !== true) {
			// Nếu không bật AJAX filter, chỉ chạy initLoadMore cũ (hoặc không làm gì nếu đã có logic reload mặc định)
			initLoadMoreLegacy();
			return;
		}

		const container = $('#product-grid-container');
		const loader = $('#ajax-loader');
		const loadMoreBtn = $('#load-more-products');

		// 1. Click Category
		$(document).on('click', '.ajax-cat-link', function(e) {
			e.preventDefault();
			const slug = $(this).data('slug');
			
			// Update active state
			$('.category-list li').removeClass('active');
			$(this).parent().addClass('active');

			// Set hidden input & Title
			$('#input-product-cat').val(slug);
			const catName = $(this).text().trim();
			const prefix = $('#archive-title').data('prefix') || '';
			$('#archive-title .text').text(prefix + catName);

			applyFilters(1);
		});

		// 2. Change Sort
		$(document).on('change', '.ajax-sort-select', function() {
			const val = $(this).val();
			$('#input-orderby').val(val === 'all' ? '' : val);
			applyFilters(1);
		});

		// 3. Price Filter Form
		$('#price-filter-form').on('submit', function(e) {
			if (productList.data('ajax-filter') === true) {
				e.preventDefault();
				applyFilters(1);
			}
		});

		// 4. Load More
		$(document).on('click', '#load-more-products', function(e) {
			e.preventDefault();
			const page = parseInt($(this).data('current-page'));
			applyFilters(page + 1, true);
		});

		// 4.1 Show Less
		$(document).on('click', '#show-less-products', function(e) {
			e.preventDefault();
			applyFilters(1, false);
			$('html, body').animate({
				scrollTop: container.offset().top - 250
			}, 500);
		});

		// 5. Remove Filter
		// mặc đinh "btn-remove-filter" hidden
		$('.btn-remove-filter').hide();

		$(document).on('click', '.btn-remove-filter', function(e) {
			e.preventDefault();
			
			// Reset form values
			$('#input-product-cat').val('');
			$('#input-orderby').val('');
			$('#input-min-price').val(0);
			$('#input-max-price').val(500000000);
			
			// Reset UI components
			$('.category-list li').removeClass('active');
			$('.ajax-sort-select').val('all');
			
			// Reset Slider
			const slider = document.getElementById('price-slider');
			if (slider && slider.noUiSlider) {
				slider.noUiSlider.set([0, 500000000]);
			}
			
			// Reset Title
			const archiveTitle = $('#archive-title');
			const defaultTitle = archiveTitle.data('default-title');
			archiveTitle.find('.text').text(defaultTitle);

			applyFilters(1);
		});

		/**
		 * Core Filter Function
		 */
		function applyFilters(page = 1, append = false) {
			const minPrice = $('#input-min-price').val();
			const maxPrice = $('#input-max-price').val();
			const productCat = $('#input-product-cat').val() || '';
			const orderby = $('#input-orderby').val() || '';

			// Toggle Clear Filter button
			const hasFilter = (productCat !== '' || parseInt(minPrice) > 0 || parseInt(maxPrice) < 500000000 || orderby !== '');
			if (hasFilter) {
				$('.btn-remove-filter').show();
			} else {
				$('.btn-remove-filter').hide();
			}

			if (!append) {
				loader.css('display', 'flex').fadeIn(200);
			} else {
				loadMoreBtn.addClass('loading').prop('disabled', true);
				loadMoreBtn.find('i').addClass('fa-spin');
			}

			$.ajax({
				url: canhcam_params.ajax_url,
				type: 'POST',
				data: {
					action: 'load_more_products',
					page: page,
					product_cat: productCat,
					min_price: minPrice,
					max_price: maxPrice,
					orderby: orderby,
					page_id: pageId,
					is_load_more: productList.data('is-load-more') === true ? 'true' : 'false'
				},
				success: function(response) {
					if (response.success) {
						const data = response.data;
						if (append) {
							if (data.html.trim()) {
								container.append(data.html);
								loadMoreBtn.data('current-page', page);
								$('#show-less-products').show();

								if (page >= parseInt(data.max_pages)) {
									loadMoreBtn.hide();
								}
							} else {
								loadMoreBtn.hide();
							}
						} else {
							container.html(data.html);
							
							// Update Pagination / Load More Button
							if (data.pagination) {
								$('#product-pagination-container').html(data.pagination);
							} else {
								$('#product-pagination-container').empty();
							}

							// Handle Load More Logic (Update button data if exists)
							const updatedLoadMore = $('#load-more-products');
							if (updatedLoadMore.length) {
								loadMoreBtn.data('current-page', 1);
								loadMoreBtn.data('max-pages', data.max_pages);
							}

							$('#show-less-products').hide();
							updateURL(productCat, minPrice, maxPrice, orderby);

							// Scroll to top of grid after filter
							$('html, body').animate({
								scrollTop: container.offset().top - 250
							}, 500);
						}

					}

					refreshPlugins();
				},
				complete: function() {
					loader.fadeOut(200);
					loadMoreBtn.removeClass('loading').prop('disabled', false);
					loadMoreBtn.find('i').removeClass('fa-spin');
				}
			});
		}

	 

		function updateURL(cat, min, max, sort) {
			let url = new URL(window.location.href);
			if (cat) url.searchParams.set('product_cat', cat); else url.searchParams.delete('product_cat');
			if (min > 0) url.searchParams.set('min_price', min); else url.searchParams.delete('min_price');
			if (max < 500000000) url.searchParams.set('max_price', max); else url.searchParams.delete('max_price');
			if (sort) url.searchParams.set('orderby', sort); else url.searchParams.delete('orderby');
			window.history.pushState({}, '', url);
		}
	}

	function initLoadMoreLegacy() {
		$('#load-more-products').on('click', function(e) {
			// Keep the previous logic for non-AJAX pages if any
			// (Hiện tại hầu hết logic đã dồn vào initAjaxFilters)
		});
	}

	/**
	 * Initialize Price Range Filter using noUiSlider
	 */
	function initPriceFilter() {
		const slider = document.getElementById('price-slider');
		if (!slider) return;

		const minInput = document.getElementById('input-min-price');
		const maxInput = document.getElementById('input-max-price');
		const minLabel = document.getElementById('price-min-label');
		const maxLabel = document.getElementById('price-max-label');

		const minVal = parseInt(slider.dataset.min);
		const maxVal = parseInt(slider.dataset.max);
		const startMin = parseInt(slider.dataset.startMin);
		const startMax = parseInt(slider.dataset.startMax);

		noUiSlider.create(slider, {
			start: [startMin, startMax],
			connect: true,
			step: 500000, // Bước nhảy 500k
			range: {
				'min': minVal,
				'max': maxVal
			},
			format: {
				to: function (value) {
					return Math.round(value);
				},
				from: function (value) {
					return Math.round(value);
				}
			}
		});

		// Update labels and inputs on slider update
		slider.noUiSlider.on('update', function (values, handle) {
			const val = values[handle];
			if (handle === 0) {
				if (minInput) minInput.value = val;
				if (minLabel) minLabel.innerHTML = formatVND(val);
			} else {
				if (maxInput) maxInput.value = val;
				if (maxLabel) maxLabel.innerHTML = formatVND(val);
			}
		});

		// Auto trigger AJAX Filter when dragging finishes
		slider.noUiSlider.on('change', function () {
			$('#price-filter-form').submit();
		});
	}

	/**
	 * Helper: Format Number to VND String
	 */
	function formatVND(amount) {
		return new Intl.NumberFormat('vi-VN', {
			style: 'currency',
			currency: 'VND',
			minimumFractionDigits: 0
		}).format(amount);
	}

	  function refreshPlugins() {
			window.lozad.observe();
		}



	

})(jQuery);
