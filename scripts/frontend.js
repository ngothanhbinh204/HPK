/**
 * Frontend Scripts for CanhCam Theme
 */
(function($) {
	'use strict';

	$(document).ready(function() {
		initPriceFilter();
		initAjaxFilters();
	});

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
			$('#archive-title').text(prefix + catName);

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

		// 5. Remove Filter
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
			archiveTitle.text(defaultTitle);

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
					orderby: orderby
				},
				success: function(response) {
					if (append) {
						if (response.trim()) {
							container.append(response);
							loadMoreBtn.data('current-page', page);
							
							const maxPages = parseInt(loadMoreBtn.data('max-pages'));
							if (page >= maxPages) {
								loadMoreBtn.parent().fadeOut();
							}
						} else {
							loadMoreBtn.parent().fadeOut();
						}
					} else {
						container.html(response);
						loadMoreBtn.data('current-page', 1);
						
						// Update Max Pages from hidden input in response
						const newMaxPages = parseInt($('#data-ajax-max-pages').val()) || 1;
						loadMoreBtn.data('max-pages', newMaxPages);
						
						if (newMaxPages <= 1) {
							loadMoreBtn.parent().hide();
						} else {
							loadMoreBtn.parent().show();
						}
						
						// Update URL (Optional but good)
						updateURL(productCat, minPrice, maxPrice, orderby);
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

	   function refreshPlugins() {
			window.lozad.observe();
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

})(jQuery);
