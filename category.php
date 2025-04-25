<?php get_header(); ?>

<div class="page">
		<aside class="sidebar">
			<div class="sidebar__container">

				<div class="logo">
					<div class="logo__name"><img src="<?php bloginfo('template_directory');?>/assets/img/logo.svg" alt=""></div>
					<div class="logo__desc">База знаний по сервису, новости, кейсы</div>
				</div>
				<nav class="menu">
					<div class="menu__body">

						<div class="menu__mainmenu">
							<a href="https://blog.botbrother.ru/" class="menu__item ">Главная</a>
							<a href="/base/" class="menu__item menu__item_active">База знаний</a>

							<?php
									$parent_category = get_term_by('name', 'База знаний', 'category');

									if ($parent_category && !is_wp_error($parent_category)) {
									
										$categories = get_terms(array(
											'taxonomy' => 'category',
											'parent'   => $parent_category->term_id,
											'hide_empty' => true,
										));
									
										// Выводим категории, если они существуют
										if ($categories && !is_wp_error($categories)) {
											foreach ($categories as $category) {

												$class = 'menu__item menu__item_submenu';
										
										// Проверяем, если текущая категория совпадает с текущей итерируемой категорией или текущая категория является дочерней для итерируемой категории
										// if ($current_category === $category->term_id || cat_is_ancestor_of($category->term_id, $current_category)) {
										// 	// Если текущая категория совпадает с текущей итерируемой категорией или является дочерней, добавляем класс "menu__item_active"
										// 	$class .= ' menu__item_active';
										// }
										echo '<a href="' . get_category_link($category->term_id) . '" class="' . $class . '">' . $category->name . '</a>';
											}
										}
									}
								?>

								<!-- отображение со всеми категориями, но выбранной активной подкатегорией -->

								<!-- <?php
									// $categories = get_terms('category', array(
									// 'hide_empty' => true,
									// ));
									// $counter = 0;

									// $categories = get_the_category();
									// $current_category = !empty($categories) ? $categories[0]->term_id : 0;
									
									// // Получаем список всех категорий
									// $all_categories = get_terms('category', array('hide_empty' => true));
									
									// foreach ($all_categories as $category) {
									// 	$class = 'menu__item menu__item_submenu';
										
									// 	// Проверяем, если текущая категория совпадает с текущей итерируемой категорией или текущая категория является дочерней для итерируемой категории
									// 	if ($current_category === $category->term_id || cat_is_ancestor_of($category->term_id, $current_category)) {
									// 		// Если текущая категория совпадает с текущей итерируемой категорией или является дочерней, добавляем класс "menu__item_active"
									// 		$class .= ' menu__item_active';
									// 	}
									// 	echo '<a href="' . get_category_link($category->term_id) . '" class="' . $class . '">' . $category->name . '</a>';
									// }
								?> -->


							<a href="/blog/" class="menu__item">Блог</a>
							<a href="#" class="menu__item menu__item_submenu">Новости</a>
							<a href="#" class="menu__item menu__item_submenu">Кейсы</a>
							<a href="http://BotBrother.ru" class="menu__item">Сервис BotBrother.ru</a>
							<a href="https://t.me/bbroofficial" class="menu__item menu__item_submenu">Канал в Telegram</a>
							<a href="https://dzen.ru/botbrother" class="menu__item menu__item_submenu">Дзен</a>
		
						</div>
						<div class="menu__widgets">
							<div class="popular">
								<div class="popular__title">Популярные статьи</div>
								<div class="popular__list">

								<?php
								global $post;

								$myposts = get_posts([
									'numberposts' => 5,
								]);

								if ($myposts) {
									foreach ($myposts as $post) {
										setup_postdata($post);
										?>
											<a href="<?php the_permalink(); ?>" class="popular__link"><?php the_title(); ?></a>
									<?php }
								}
								wp_reset_postdata(); // Сбрасываем $post
								?>
								</div>
							</div>
						</div>
						<div class="menu__text">Блог ведется командой BotBrother.ru. При копировании материалов с сайта ссылка на него обязательна.</div>
					</div>
				</nav>
				<div class="burger">
					<div class="burger__icon">
						<div class="burger__line burger__line_1"></div>
						<div class="burger__line burger__line_2"></div>
						<div class="burger__line burger__line_3"></div>
					</div>
				</div>
			</div>
		</aside>
		<main class="main">
        <div class="heading">
		
		<?php if (have_posts()) { ?>
		<div class="section">
				<div class="section__head">
					<h1 class="heading__title"><?php single_cat_title('', true)?></h1>
		<?php }
		$category = get_queried_object();

		if (!empty($category) && !is_wp_error($category)) {
			// Категория найдена

			echo '<div class="heading__text">'. $category->description.'</div>';

		echo '</div>';

			$args = array(
				'category_name' => $category->slug, 
				'posts_per_page' => -1 // -1 для вывода всех постов, 10 для вывода 10 последних постов
			); 
			 
			global $post;
			$myposts = get_posts($args);

			$myposts = get_posts([
				'numberposts' => 4,
				'orderby'     => 'rand'
			]);

			$mypostscount = get_posts([
				'numberposts' => -1,
			]);
			
			// Создаем массив, содержащий только ID постов
			$post_ids = wp_list_pluck($mypostscount, 'ID');
			
				$random_posts = get_posts([
					'numberposts' => 1,
					'orderby'     => 'rand',
				]);
				
				// Check if any random post was found
				if (!empty($random_posts)) {
					$random_post = $random_posts[0]; // Retrieve the first (and only) random post
				}
			if ($myposts) {
				foreach ($myposts as $post) {
					setup_postdata($post);
					?>
					<div class="post">
						<?php if (has_post_thumbnail()) {
							echo '<a href="#" class="post__image image">';
							the_post_thumbnail(
								"full",
								array('', ''),
								array('class' => 'product__image')
							);
							echo '</a>';
						} ?>

						<a href="<?php the_permalink(); ?>" class="post__title"><?php the_title(); ?></a>
						<a href="<?php the_permalink(); ?>" class="post__text">
                            <?php
                                if (has_excerpt()) {
                                    the_excerpt();
                                }
						?></a>

						<div class="post__meta">
							<div class="post__meta-list">
								<?php
								$categories = get_the_category();
								if (!empty($categories)) {
									foreach ($categories as $category) {
										echo '<a href="#" class="post__category">' . esc_html($category->name) . '</a>';
									}
								}
								?>
							</div>
							<div class="post__meta-list">
								<?php
								$tags = get_the_tags();
								if (!empty($tags)) {
									foreach ($tags as $tag) {
										echo '<a href="#" class="post__tag">' . esc_html($tag->name) . '</a>';
									}
								}
								?>
							</div>
						</div>
						<div class="post__data"><?php the_time('F j, Y'); ?></div>

					</div>
				<?php }
			}
			?>
			<div class="post-navigation">

				<?php if ($random_post) { ?>
					<a href="<?php echo get_permalink($random_post); ?>" class="next-post-link">Следующий пост</a>
				<?php } ?>
			</div>
			<?php
			}

		// Восстанавливаем данные глобального объекта $post
		wp_reset_postdata();
		?>
		</div>
	</main>
</div>
<?php get_footer();?>