<?php

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/css/style.css');

	// wp_deregister_script( 'jquery' );
	// wp_register_script( 'jquery', '//https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
	// wp_enqueue_script( 'jquery' );

    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.4.1.min.js');
	wp_enqueue_script( 'jquery');

	//  wp_enqueue_script( 'jquery-3.4.1.min', get_template_directory_uri() . '/assets/js/jquery-3.4.1.min.js', array('jquery'), true );
     wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'));
     wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.js', array('jquery'));
     wp_enqueue_script( 'theia-sticky-sidebarMin', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.min.js', array('jquery'));

});

add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');
add_theme_support('post-thumbnails');

add_filter( 'upload_mimes', 'svg_upload_allow' );

# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';

	return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

	// WP 5.1 +
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) ){
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	}
	else {
		$dosvg = ( '.svg' === strtolower( substr( $filename, -4 ) ) );
	}

	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if( $dosvg ){

		// разрешим
		if( current_user_can('manage_options') ){

			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext']  = false;
			$data['type'] = false;
		}

	}

	return $data;
}

function add_anchor_links($content) {
    preg_match_all('/<h([1-6]).*?>(.*?)<\/h[1-6]>/i', $content, $matches, PREG_SET_ORDER);

    $anchor_links = '';

    if (!empty($matches)) {
		 echo '<div class="article__toc">';
        $anchor_links .= '<ul>';

        foreach ($matches as $match) {
            $heading_level = $match[1];
            $heading_text = strip_tags($match[2]);
            $heading_id = sanitize_title($heading_text);
            $anchor_links .= '<li><a href="#' . $heading_id . '" class="anc">' . $heading_text . '</a></li>';
            $content = str_replace($match[0], '<h' . $heading_level . ' id="' . $heading_id . '">' . $heading_text . '</h' . $heading_level . '>', $content);
        }

        $anchor_links .= '</ul></div>';
    }

    $content = $anchor_links . ' <div class="article__content">'. $content . '</div>';

    return $content;
}
add_filter('the_content', 'add_anchor_links');

add_action( 'wp_ajax_infinite_scroll', 'infinite_scroll_ajax_handler' );
add_action( 'wp_ajax_nopriv_infinite_scroll', 'infinite_scroll_ajax_handler' );

function add_image_class_to_figure($content) {
    $content = preg_replace('/(<figure[^>]*class=[\'"])/i', '$1image ', $content);
    return $content;
}
add_filter('the_content', 'add_image_class_to_figure');

function add_custom_styles_to_lists($content) {
    // Регулярное выражение для поиска тегов <ol> и <ul>
    $pattern = '/<(ol|ul)(.*?)>(.*?)<\/(ol|ul)>/s';
    
    // Функция обратного вызова для подключения стилей к совпадениям
    $callback = function ($matches) {
        $tag = $matches[1];
        $style = 'list-style: none;';
        
        // Добавить специфические стили для <ol>
        if ($tag === 'ol') {
            $style .= 'counter-reset: myCounter;';
        }
        
        $style .= '/* Ваши стили для списка здесь */';
        
        // Добавить стили для маркеров элементов <ol>
        if ($tag === 'ol') {
            $style .= 'list-style: none; counter-reset: myCounter;';
        }
        
        return "<{$tag}{$matches[2]} style='{$style}'>{$matches[3]}</{$tag}>";
    };
    
    // Выполнить поиск и замену в содержимом поста
    $content = preg_replace_callback($pattern, $callback, $content);
    
    return $content;
}
add_filter('the_content', 'add_custom_styles_to_lists');

?>