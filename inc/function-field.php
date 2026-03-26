<?php
// Custom field class for page
function add_field_custom_class_body()
{
	acf_add_local_field_group(array(
		'key' => 'class_body',
		'title' => 'Body: Add Class',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
	));
	acf_add_local_field(array(
		'key' => 'add_class_body',
		'label' => 'Add class body',
		'name' => 'Add class body',
		'type' => 'text',
		'parent' => 'class_body',
	));
}
add_action('acf/init', 'add_field_custom_class_body');

//

function add_field_select_banner()
{
	acf_add_local_field_group(array(
		'key' => 'select_banner',
		'title' => 'Banner: Select Page',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			// Thêm taxonomy ở dưới
			// array(
			// 	array(
			// 		'param' => 'taxonomy',
			// 		'operator' => '==',
			// 		'value' => 'danh-muc-san-pham'
			// 	)
			// )
		),
	));
	acf_add_local_field(array(
		'key' => 'banner_select_page',
		'label' => 'Chọn banner hiển thị',
		'name' => 'Chọn banner hiển thị',
		'type' => 'post_object',
		'post_type' => 'banner',
		'multiple' => 1,
		'parent' => 'select_banner',
	));
}
add_action('acf/init', 'add_field_select_banner');

function add_theme_config_options()
{
	// Add the field group
	acf_add_local_field_group(array(
		'key' => 'group_theme_config',
		'title' => 'Theme Configuration',
		'fields' => array(
			array(
				'key' => 'tab_config',
				'label' => 'Config',
				'name' => 'tab_config',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_config_head',
				'label' => 'Config Head',
				'name' => 'config_head',
				'type' => 'textarea',
				'instructions' => 'Add custom code for header (CSS, meta tags, etc)',
				'required' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 4,
				'new_lines' => '',
			),
			array(
				'key' => 'field_config_body',
				'label' => 'Config Body',
				'name' => 'config_body',
				'type' => 'textarea',
				'instructions' => 'Add custom code for body (JS, tracking code, etc)',
				'required' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 4,
				'new_lines' => '',
			),
			array(
				'key' => 'field_archive_product_banner',
				'label' => 'Banner mặc định (Archive)',
				'name' => 'archive_product_banner',
				'type' => 'image',
				'instructions' => 'Banner hiển thị cho các trang lưu trữ nếu không có banner riêng.',
				'required' => 0,
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-settings',
				),
			),
		),
		'menu_order' => 999,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
}
add_action('acf/init', 'add_theme_config_options');

function add_field_product_list_settings()
{
	acf_add_local_field_group(array(
		'key' => 'group_product_list_settings',
		'title' => 'Cài Đặt Danh Sách Sản Phẩm (Loại Hình)',
		'fields' => array(
			array(
				'key' => 'page_product_type',
				'label' => 'Loại Hình Sản Phẩm Hiển Thị',
				'name' => 'page_product_type',
				'type' => 'taxonomy',
				'instructions' => 'Chọn Loại Hình sản phẩm sẽ hiển thị trên trang này (Ví dụ: Cho Thuê hoặc Bán Máy).',
				'taxonomy' => 'product_type',
				'field_type' => 'multi_select',
				'return_format' => 'id',
				'add_term' => 0,
				'load_terms' => 0,
				'save_terms' => 0,
			),
			array(
				'key' => 'page_product_type_empty',
				'label' => 'Bao Gồm SP Chưa Gán Loại Hình',
				'name' => 'page_product_type_empty',
				'type' => 'true_false',
				'instructions' => 'Nếu bật, danh sách sẽ hiển thị thêm các sản phẩm chưa được gán bất kỳ Loại Hình nào.',
				'default_value' => 0,
				'ui' => 1,
			),
			array(
				'key' => 'page_product_prefix',
				'label' => 'Tiền Tố Tiêu Đề Danh Mục',
				'name' => 'page_product_prefix',
				'type' => 'text',
				'instructions' => 'Nhập tiền tố sẽ hiển thị trước tên danh mục (Ví dụ: "Cho Thuê"). Để trống nếu không muốn dùng tiền tố.',
				'default_value' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/template-product-list.php',
				),
			),
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'templates/template-rent.php',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
}
add_action('acf/init', 'add_field_product_list_settings');

function add_field_product_cat_settings()
{
	acf_add_local_field_group(array(
		'key' => 'group_product_cat_settings',
		'title' => 'Cài Đặt Danh Mục',
		'fields' => array(
			array(
				'key' => 'product_cat_type',
				'label' => 'Thuộc Loại Hình Sản Phẩm Nào?',
				'name' => 'product_cat_type',
				'type' => 'taxonomy',
				'instructions' => 'Chọn Loại hình (VD: Bán máy, Cho thuê) mà Danh mục này thuộc về. Nếu để trống, danh mục này sẽ xuất hiện ở tất cả các trang.',
				'taxonomy' => 'product_type',
				'field_type' => 'multi_select',
				'return_format' => 'id',
				'add_term' => 0,
				'load_terms' => 0,
				'save_terms' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_cat',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
}
add_action('acf/init', 'add_field_product_cat_settings');


// add cột ở admin 

add_filter('manage_edit-product_cat_columns', function ($columns) {
    $columns['product_cat_type'] = 'Loại sản phẩm';
    return $columns;
});

add_filter('manage_product_cat_custom_column', function ($content, $column_name, $term_id) {

    if ($column_name === 'product_cat_type') {

        $terms = get_field('product_cat_type', 'product_cat_' . $term_id);

        if (!empty($terms)) {

            $names = array_map(function ($term_id) {
                $term = get_term($term_id);
                return $term ? $term->name : '';
            }, $terms);

            $content = implode(', ', $names);

        } else {
            $content = '—';
        }
    }

    return $content;

}, 10, 3);