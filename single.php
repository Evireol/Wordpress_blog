<?php get_header();?>
<?php the_post();?>

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
							<a href="https://blog.botbrother.ru/" class="menu__item">Главная</a>
							<a href="/base/" class="menu__item">База знаний</a>

							<?php
									$parent_category = get_term_by('name', 'База знаний', 'category');

									// Проверяем, существует ли родительская категория "База знаний"
									if ($parent_category && !is_wp_error($parent_category)) {
									
										// Получаем категории, у которых родительская категория равна ID родительской категории "База знаний"
										$categories = get_terms(array(
											'taxonomy' => 'category',
											'parent'   => $parent_category->term_id,
											'hide_empty' => true,
										));
									
										// Выводим категории, если они существуют
										if ($categories && !is_wp_error($categories)) {
											foreach ($categories as $category) {
												echo '<a href="' . get_category_link($category->term_id) . '" class="menu__item menu__item_submenu">' . $category->name . '</a>';
											}
										}
									}
								?>


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
			
		<div class="section breadcrumbs">
		<div class="section breadcrumbs">
		<?php
    echo '<a class="breadcrumbs__link" href="' . home_url() . '">Главная</a>';
    echo '<span class="breadcrumbs__separ"></span>';

    if (is_category()) {
        $category = get_queried_object();
        echo '<span class="breadcrumbs__title">' . $category->name . '</span>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if (!empty($categories)) {
            echo '<a class="breadcrumbs__link" href="' . get_category_link($categories[0]->term_id) . '">' . $categories[0]->name . '</a>';
            echo '<span class="breadcrumbs__separ"></span>';
            if (count($categories) > 1) {
                echo '<a class="breadcrumbs__link" href="' . get_category_link($categories[1]->term_id) . '">' . $categories[1]->name . '</a>';
            }
        }
    } elseif (is_page()) {
        echo '<span class="breadcrumbs__title">' . get_the_title() . '</span>';
    }
    ?>
</div>

</div>

			<article class="article">

							<h2 href="<?php the_permalink(); ?>" class="article__title"><?php the_title(); ?></h2>
							<p href="<?php the_permalink(); ?>" class="post__text"><?php the_content(); ?></p>

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


						<script>
							jQuery(document).ready(function($) {
							$('h2, h3').addClass('section__title');
							});		
						</script>

						<script>
						jQuery(document).ready(function($) {
						// Находим все элементы изображений внутри основной области контента
						var images = $('.wp-image-110');

						// Перебираем каждое изображение
						images.each(function() {
							// Обертываем изображение в тег <a>
							$(this).wrap('<a href="#" class="post__image image"></a>');
						});
						});
						</script>
			</article>
			<div class="section">
				<div class="section__head">
				<h2 class="section__title">Другие статьи на сайте</h2>
				<div class="section__desc">Если вам нравятся наши матералы, то обратите внимание на следующие материалы</div>
				</div>

			
				<?php
				global $post;

				$current_post_id = get_the_ID();
				$myposts = get_posts([
					'numberposts' => 4,
					'orderby'     => 'rand'
				]);

				$mypostscount = get_posts([
					'numberposts' => -1,
				]);
				
				// Создаем массив, содержащий только ID постов
				$post_ids = wp_list_pluck($mypostscount, 'ID');
				
				// Находим индекс текущего поста в массиве
				$current_post_index = array_search($current_post_id, $post_ids);
				
				if ($mypostscount) {
					// Получаем ID предыдущего и следующего постов
					// $previous_post_id = ($current_post_index > 0) ? $post_ids[$current_post_index - 1] : null;
					// $next_post_id = ($current_post_index !== false && $current_post_index < count($mypostscount) - 1) ? $post_ids[$current_post_index + 1] :  null;
				
					$random_posts = get_posts([
						'numberposts' => 1,
						'orderby'     => 'rand',
					]);
					
					// Check if any random post was found
					if (!empty($random_posts)) {
						$random_post = $random_posts[0]; // Retrieve the first (and only) random post
					}

					foreach ($myposts as $post) {
						setup_postdata($post);
						if ($post->ID !== $current_post_id) {
							?>
							<div class="post">
								<?php if (has_post_thumbnail()) {
									echo '<div href="#" class="post__image image">';
									echo '<a href='.  get_the_permalink() .'>';
									the_post_thumbnail(
										"full",
										array('', ''),
										array('class' => 'product__image')
									);
									echo '</a>';
									echo '</div>';
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