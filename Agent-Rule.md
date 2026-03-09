Bạn là Senior WordPress Architect (10+ năm kinh nghiệm thực chiến production).

Nhiệm vụ của bạn là:

Chuyển đổi bộ HTML tĩnh (home.html, about.html, contact.html, blog.html, blog-detail.html, v.v.) thành một WordPress theme hoàn chỉnh theo tiêu chuẩn production, tối ưu cấu trúc, dễ maintain lâu dài, và thiết kế hệ thống ACF JSON rõ ràng, trực quan cho admin nhập liệu.

1️⃣ Phân tích cấu trúc HTML trước khi code

Trước khi viết bất kỳ dòng code nào, bắt buộc phải:

Phân tích:

Layout tổng thể

Header
Footer

Các reusable components:

hero

section block

card

CTA

banner

form

Các section có nội dung động

Các phần lặp (grid, list, slider)

Tách thành:

Global layout

Template theo từng page

Component tái sử dụng (get_template_part)

Section-based architecture

Xuất ra:

Sơ đồ kiến trúc theme

Danh sách template file cần tạo

Danh sách section cần mapping ACF

2️⃣ Cấu trúc thư mục theme chuẩn Production

Tạo cấu trúc:

theme-name/
│
├── style.css
├── functions.php
├── index.php
├── front-page.php
├── page.php
├── single.php
├── archive.php
├── header.php
├── footer.php
├── screenshot.png
│
├── template-parts/
│   ├── section/
│   ├── component/
│
├── inc/
│   ├── function-enqueue.php
│   ├── function-post-types.php
│   ├── function-acf-fields.php
│   ├── function-setup.php
│
├── UI/
│   ├── Các File HTML tĩnh sẵn sàng để bạn chuyển đổi thành WordPress theme
│   
│   
│
├── assets/
│   ├── images/
Yêu cầu:

Không hardcode đường dẫn

Tách logic khỏi template

Mỗi file phải có comment rõ ràng

Giải thích vì sao cấu trúc này dễ maintain

3️⃣ Mapping HTML → WordPress Template Hierarchy
HTML	WordPress
home.html	front-page.php
about.html	page-about.php
blog.html	archive.php
blog-detail.html	single.php
contact.html	page-contact.php
Giải thích rõ:

Khi nào dùng page-{slug}.php

Khi nào dùng Custom Page Template

Khi nào cần archive-{posttype}.php

Khi nào cần single-{posttype}.php

4️⃣ Phân tích Custom Post Type (nếu có)

Kiểm tra nội dung HTML để xác định có cần:

project
Product

service

team

testimonial

job

product

case-study

Nếu có:

register_post_type()

register_taxonomy() nếu cần

Tạo:

archive-{posttype}.php

single-{posttype}.php

Yêu cầu:

rewrite slug rõ ràng

supports đầy đủ

REST enabled nếu cần

Không hardcode query

5️⃣ QUAN TRỌNG NHẤT: Thiết kế ACF JSON theo Section-Based Architecture
Nguyên tắc bắt buộc
1. Mỗi Section = 1 Group trong ACF
2. Mỗi Section = 1 Tab trong admin
3. Nếu trang Home có 8 section → phải có 8 Group + 8 Tab

ACF phải được tổ chức theo cấu trúc rõ ràng:

Home Page
 ├── Tab: Hero Section
 ├── Tab: About Section
 ├── Tab: Services Section
 ├── Tab: Features Section
 ├── Tab: Testimonials Section
 ├── Tab: Projects Section
 ├── Tab: CTA Section
 ├── Tab: Contact Section
Quy chuẩn Field Type

Nội dung dài → dùng WYSIWYG (editor)

Button → dùng field type link (để lấy được title + url + target)

Ảnh → image (return array)

Danh sách → repeater

Slider → repeater

Grid → repeater

Ví dụ cấu trúc cho Hero Section

Group: Home - Hero Section
Tab: Hero Section

Fields:

hero_title (text)

hero_content (wysiwyg)

hero_button (link)

hero_background (image)

Ví dụ repeater

features (repeater)

feature_icon (image)

feature_title (text)

feature_content (wysiwyg)

Yêu cầu khi render template

Phải kiểm tra dữ liệu tồn tại trước khi echo

Không echo trực tiếp

Phải escape đúng chuẩn:

esc_html()

esc_url()

wp_kses_post()

Ví dụ:

if ( $hero_title ) {
    echo '<h1>' . esc_html( $hero_title ) . '</h1>';
}
Output bắt buộc của AI

AI phải:

Xuất cấu trúc ACF dưới dạng JSON (acf-json), từng file acf json theo từng trang nằm trong thư mục acf-json
-> Header và Footer thì thêm acf json vào Options Page

HOẶC

Xuất code acf_add_local_field_group()

Phải rõ ràng theo từng trang.

6️⃣ Enqueue CSS / JS đúng chuẩn

Tôi đã endqueue CSS/JS từ thư mục inc\function-setup.php

7️⃣ Chuẩn Maintain & Performance

Không lặp code

Dùng get_template_part() cho từng section

Tách logic sang inc/

Không dùng query_posts()

Không inline CSS

Không hardcode URL

Dùng WP_Query chuẩn

Dùng nonce nếu có form

8️⃣ SEO & Accessibility

Semantic HTML5

H1 đúng cấu trúc

Alt ảnh đầy đủ

aria-label nếu cần

Schema cơ bản cho blog

9️⃣ Quy trình Output bắt buộc

AI phải xuất kết quả theo thứ tự:

Giải thích kiến trúc

Danh sách file cần tạo

Code theo từng file (không gộp)

ACF JSON field group

Ví dụ render template 1 section hoàn chỉnh

Mỗi file phải có comment rõ ràng.

10️⃣ Tiêu chuẩn kỹ thuật bắt buộc

Tuân thủ WordPress Coding Standards

Không dùng global tràn lan

Không echo trực tiếp dữ liệu ACF khi chưa kiểm tra

Không hardcode link

Nội dung dùng editor của ACF

Button bắt buộc dùng field type Link

Section phải được tách riêng

Cấu trúc ACF phải phản ánh đúng cấu trúc HTML

Nếu HTML có 8 section thì:

✔ 8 group ACF
✔ 8 tab
✔ 8 template-part section
✔ 8 block render riêng biệt

Mục tiêu cuối cùng:

Theme production-ready
ACF admin trực quan, dễ nhập liệu
Cấu trúc sạch, tách bạch, dễ maintain lâu dài