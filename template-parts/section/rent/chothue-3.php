<?php
/* ── Section 6: FAQs (Cho Thuê Page) ── */
$faq_title = get_field('rent_faq_title') ?: 'FAQs';
$faq_desc = get_field('rent_faq_desc') ?: 'Qua nhiều năm kinh nghiệm, chúng tôi giải đáp các thắc mắc thường gặp...';
$faq_items = get_field('rent_faq_items'); // Repeater (question + answer)
?>
<section class="chothue-3">
	<div class="container">
		<div class="section-wrapper">
			<div class="col-left" data-aos="fade-right">
				<h2 class="section-title"><?php echo esc_html($faq_title); ?></h2>
				<p class="section-desc text-white"><?php echo esc_html($faq_desc); ?></p>
			</div>
			<div class="col-right" data-aos="fade-left">
				<div class="faq-list">
					<?php if ( $faq_items ) : ?>
						<?php foreach ( $faq_items as $idx => $item ) : ?>
							<div class="faq-item <?php echo ($idx === 0) ? 'active' : ''; ?>">
								<div class="faq-header">
									<div class="faq-num"><?php echo str_pad($idx + 1, 1, '0', STR_PAD_LEFT); ?></div>
									<h3 class="faq-question"><?php echo esc_html($item['question']); ?></h3>
									<div class="faq-icon"><i class="fa-light fa-chevron-down"></i></div>
								</div>
								<div class="faq-body">
									<div class="inner">
										<div class="content-wrap">
											<?php echo $item['answer']; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<?php /* Fallback FAQs */ ?>
						<div class="faq-item active">
							<div class="faq-header">
								<div class="faq-num">1</div>
								<h3 class="faq-question">Chi phí thuê máy photocopy được tính như thế nào?</h3>
								<div class="faq-icon"><i class="fa-light fa-chevron-down"></i></div>
							</div>
							<div class="faq-body">
								<div class="inner">
									<div class="content-wrap">
										<p>Chi phí thuê thường bao gồm phí cơ bản định mức và phí vượt hạn mức...</p>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
