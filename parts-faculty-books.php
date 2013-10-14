<li id="booksTab">
<?php
	$author_id = get_the_ID();
	$single_books_query = new WP_Query(array(
	    'post_type' => 'post',
	    'category_name' => 'books',
	    'meta_query' => array(                  
	       array(
	         'key' => 'ecpt_pub_author',                  
	         'value' => $author_id,               
	         'type' => 'NUMERIC',                 
	         'compare' => '='                 
	       ),
	      'posts_per_page' => '-1'
    ))); 
    
    
	if ( $single_books_query->have_posts() ) : while ($single_books_query->have_posts()) : $single_books_query->the_post(); ?>
		
		    <a href="<?php the_permalink(); ?>">
		

	    		<?php if ( has_post_thumbnail()) {  the_post_thumbnail('directory', array('class'	=> "floatleft"));  } ?>
				<h5><?php the_title();?></h5>
				<h6><?php if ( get_post_meta($post->ID, 'ecpt_pub_date', true) ) : echo get_post_meta($post->ID, 'ecpt_pub_date', true);  endif; ?><?php if ( get_post_meta($post->ID, 'ecpt_publisher', true) ) :?>, <?php echo get_post_meta($post->ID, 'ecpt_publisher', true);  endif; ?></h6>
		<p><b>Role:&nbsp;<span style="text-transform:capitalize;"><?php echo get_post_meta($post->ID, 'ecpt_pub_role', true); ?></span>
		<?php if (get_post_meta($post->ID, 'ecpt_author_cond', true) == 'on') { $faculty_post_id2 = get_post_meta($post->ID, 'ecpt_pub_author2', true); ?><br>
		   <?php echo get_the_title($faculty_post_id2); ?>,&nbsp;<?php echo get_post_meta($post->ID, 'ecpt_pub_role2', true); ?>
		<?php } ?>
		</b></p>
		</a>
		<hr>
	<?php endwhile; endif; ?>
</li>