<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="ctn_search-field">
		<label>
			<span class="screen-reader-text"><?php echo _x( 'Buscar', 'label' ) ?></span>
			<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( '¿Qué estás buscando?', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
		</label>
		<input type="submit" class="search-submit icon-search-find" value="k" />
	</div>
</form>