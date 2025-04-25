
<?php get_header();?>
<div class="page">
		<aside class="sidebar">
			<div class="sidebar__container">

				<div class="logo">
					<div class="logo__name"><img src="<?php bloginfo('template_directory');?>/assets/img/logo.svg" alt=""></div>
					<div class="logo__desc">База знаний по сервису, новости, кейсы</div>
				</div>
				<nav class="menu">
					<div class="menu__body">

							<?php
							if (is_active_sidebar('sidebar-blog')) {
							// Ваш код, который будет выполнен, если сайдбар активен
							dynamic_sidebar('sidebar-blog');
							} else {
							// Ваш код, который будет выполнен, если сайдбар неактивен
							echo 'Сайдбар блога неактивен.';
							}
							?>

						<div class="menu__mainmenu">
							<a href="#" class="menu__item menu__item_active">Главная</a>
							<a href="a0837804.xsph.ru/base/" class="menu__item">База знаний</a>

							
							<a href="#" class="menu__item menu__item_submenu">Подрубрика</a>


							<a href="a0837804.xsph.ru/blog/" class="menu__item">Блог</a>
							<a href="#" class="menu__item menu__item_submenu">Новости</a>
							<a href="#" class="menu__item menu__item_submenu">Кейсы</a>
							<a href="#" class="menu__item">Сервис BotBrother.ru</a>
							<a href="#" class="menu__item menu__item_submenu">Канал в Telegram</a>
							<a href="#" class="menu__item menu__item_submenu">Дзен</a>
		
						</div>
						<div class="menu__widgets">
							<div class="popular">
								<div class="popular__title">Популярные статьи</div>
								<div class="popular__list">

								
									<a href="#" class="popular__link">Как самостоятельно создать чат-бота в Telegram</a>

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
				<h1 class="heading__title">База знаний по разработке ботов в Телеграм и работе в сервисе BotBrother</h1>
				<div class="heading__text">Мы создали данную базу знаний, чтобы было проще освоить разработку ботов любой сложности в Телеграм и созданий эффективных связок с каналами. Воспользуйтесь поиском, чтобы найти ответ на интересующий вас вопрос.</div>
				
				<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
				<input class="heading__search" type="search" placeholder="Введите текст для поиска" value="<?php echo get_search_query(); ?>" name="s" />
				</form>

				<script>
					function searchOnEnter(event) {
					if (event.keyCode === 13) {
					event.preventDefault();
					event.target.form.submit();
					return false;
					}
					}
					</script>
				
			</div>


			<?php
				$categories = get_terms('category', array(
				'hide_empty' => true,
				));
				$counter = 0;


			echo '<div class="category">';

			foreach ($categories as $category) {

				
				echo '<div class="category__item">';
				echo '<div class="category__title">' . $category->name . '</div>';
				echo '<div class="category__desc">' . $category->description . '</div>';
				echo '<div class="category__articles">';
				
				$args = array(
					'category_name' => $category->name, 
					'posts_per_page' => -1 // -1 для вывода всех постов, 10 для вывода 10 последних постов
				); 
				
				$posts = get_posts($args);
				
				if ($posts) {
					foreach ($posts as $post) {
						$post_title = $post->post_title;
						echo '<a href="#" class="category__link">' .$post_title. '<br></a>';
					}
				}

				//  echo '<a href="#" class="category__link">' .$post_title. '<br></a>';


				echo '</div>';
				echo '<a href="' . get_category_link($category->term_id) . '" class="category__more">Показать еще</a>';
				echo '</div>';
			}

			echo '</div>';
			?>

			<div class="section">
				<div class="section__head">
					<h2 class="section__title">Блог</h2>
					<div class="section__desc">В блоге мы выкладываем много полезной дополнительной информации и информируем наших пользователей обо всех изменениях</div>
				</div>
				<?php
				global $post;

				$myposts = get_posts([
					'numberposts' => -1,
				]);

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
                                } else {
                                    the_content();
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
				wp_reset_postdata(); // Сбрасываем $post
				?>
			</div>
		</main>
	</div>
<?php get_footer();?>