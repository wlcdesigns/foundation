<nav class="top-bar" data-topbar>
	<ul class="title-area">
		<li class="name">
			<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		</li>
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>

	<section class="top-bar-section">
	<?php
	wp_nav_menu(array(
    	'container' => false,
    	'menu_class' => 'right',
    	'theme_location' => '<-- your registered menu -->',
        'walker' => new F5_TOP_BAR_WALKER(),
	));
	?>
	</section>
</nav>
