<?php get_header(); ?>
	<?php
		// Check and get Sidebar Class
		$sidebar = get_post_meta($post->ID,'post-option-sidebar-template',true);
		$sidebar_class = '';
		if( $sidebar == "left-sidebar" || $sidebar == "right-sidebar"){
			$sidebar_class = "sidebar-included " . $sidebar;
		}else if( $sidebar == "both-sidebar" ){
			$sidebar_class = "both-sidebar-included";
		}

		// Translator words
		global $gdl_admin_translator;	
		if( $gdl_admin_translator == 'enable' ){
			$translator_client = get_option(THEME_SHORT_NAME.'_translator_client', 'Client');
			$translator_visit_website = get_option(THEME_SHORT_NAME.'_translator_visit_website', 'Visit Website');
			$translator_about_author = get_option(THEME_SHORT_NAME.'_translator_about_author', 'About the Author');
			$translator_social_share = get_option(THEME_SHORT_NAME.'_translator_social_shares', 'Social Share');
		}else{
			$translator_client =  __('Client','gdl_front_end');
			$translator_visit_website = __('Visit Website','gdl_front_end');		
			$translator_about_author = __('About the Author','gdl_front_end');
			$translator_social_share = __('Social Share','gdl_front_end');
		}		
		
	?>
	<div class="content-wrapper <?php echo $sidebar_class; ?>"> 
		<div class="clear"></div>
		<?php
			$left_sidebar = get_post_meta( $post->ID , "post-option-choose-left-sidebar", true);
			$right_sidebar = get_post_meta( $post->ID , "post-option-choose-right-sidebar", true);		
			
			echo "<div class='gdl-page-float-left'>";		
		?>
		
		<div class='gdl-page-item'>

		<?php 
			if ( have_posts() ){
				while (have_posts()){
					the_post();

					if( get_option(THEME_SHORT_NAME.'_use_portfolio_as') == 'portfolio style' ){
						
						// Single header was <div class="twelve columns mt0">
						echo '<div class="sixteen columns mt0">';
						echo '<h1 class="single-port-title post-title-color gdl-title gdl-divider">';
						echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
						// Inside Thumbnail
						if( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
							$item_size = "630x250";
						}else if( $sidebar == "both-sidebar" ){
							$item_size = "450x180";
						}else{
							$item_size = "930x375";
						} 
						
						$inside_thumbnail_type = get_post_meta($post->ID, 'post-option-inside-thumbnail-types', true);
						
						switch($inside_thumbnail_type){
						
							case "Image" : 
							
								$thumbnail_id = get_post_meta($post->ID,'post-option-inside-thumbnial-image', true);
								$thumbnail = wp_get_attachment_image_src( $thumbnail_id , $item_size );
								$thumbnail_full = wp_get_attachment_image_src( $thumbnail_id , 'full' );
								$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
								
								if( !empty($thumbnail) ){
									echo '<div class="single-port-thumbnail-image">';
									echo '<a href="' . $thumbnail_full[0] . '" data-rel="prettyPhoto" title="' . get_the_title() . '" ><img src="' . $thumbnail[0] .'" alt="'. $alt_text .'"/></a>'; 
									echo '</div>';
								}
								break;			
								
							case "Video" : 
							
								$video_link = get_post_meta($post->ID,'post-option-inside-thumbnail-video', true);
								echo '<div class="single-port-thumbnail-video">';
								echo get_video($video_link, gdl_get_width($item_size), gdl_get_height($item_size));
								echo '</div>';							
								break;
								
							case "Slider" : 
							
								$slider_xml = get_post_meta( $post->ID, 'post-option-inside-thumbnail-xml', true); 
								$slider_xml_dom = new DOMDocument();
								$slider_xml_dom->loadXML($slider_xml);
								
								echo '<div class="single-port-thumbnail-slider">';
								echo print_flex_slider($slider_xml_dom->documentElement, $item_size);
								echo '</div>';					
								break;
						}
						
						echo "<div class='clear'></div>";
						echo "<div class='single-port-content'>";
						echo the_content();
						echo "</div>";
						
						// Include Social Shares
						if(get_post_meta($post->ID, 'post-option-social-enabled', true) == "Yes"){
							echo "<div class='social-share-title gdl-link-title gdl-title'>";
							echo $translator_social_share;
							echo "</div>";
							include_social_shares();
							echo "<div class='clear'></div>";
						}		
						
						echo "<div class='mt30'></div>";
						echo "</div>";
						
					}else{
					
						echo '<div class="sixteen columns mt0">';	
						
						// Single header
						echo '<h1 class="single-thumbnail-title post-title-color gdl-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';
						echo '<div class="single-thumbnail-info post-info-color gdl-divider">';
						echo '<div class="single-thumbnail-date">' . get_the_time( GDL_DATE_FORMAT ) . '</div>';
						echo '<div class="single-thumbnail-author"> ' . __('by','gdl_front_end') . ' ' . get_the_author_link() . '</div>';
						$portfolio_tag = get_the_term_list( $post->ID, 'portfolio-tag', '', ', ' , '' );
						echo '<div class="single-thumbnail-tag">' . $portfolio_tag . '</div>';
						
						echo '<div class="single-thumbnail-comment">';
						comments_popup_link( __('0 Comment','gdl_front_end'), __('1 Comment','gdl_front_end'),
							__('% Comments','gdl_front_end'), '', __('Comments are off','gdl_front_end') );
						echo '</div>';
						echo '<div class="clear"></div>';
						echo '</div>';
						
						// Inside Thumbnail
						if( $sidebar == "left-sidebar" || $sidebar == "right-sidebar" ){
							$item_size = "630x200";
						}else if( $sidebar == "both-sidebar" ){
							$item_size = "450x140";
						}else{
							$item_size = "930x300";
						} 
						
						$inside_thumbnail_type = get_post_meta($post->ID, 'post-option-inside-thumbnail-types', true);
						
						switch($inside_thumbnail_type){
						
							case "Image" : 
							
								$thumbnail_id = get_post_meta($post->ID,'post-option-inside-thumbnial-image', true);
								$thumbnail = wp_get_attachment_image_src( $thumbnail_id , $item_size );
								$thumbnail_full = wp_get_attachment_image_src( $thumbnail_id , 'full' );
								$alt_text = get_post_meta($thumbnail_id , '_wp_attachment_image_alt', true);
								
								if( !empty($thumbnail) ){
									echo '<div class="blog-thumbnail-image">';
									echo '<a href="' . $thumbnail_full[0] . '" data-rel="prettyPhoto"><img src="' . $thumbnail[0] .'" alt="'. $alt_text .'"/></a>'; 
									echo '</div>';
								}
								break;
								
							case "Video" : 
							
								$video_link = get_post_meta($post->ID,'post-option-inside-thumbnail-video', true);
								echo '<div class="blog-thumbnail-video">';
								echo get_video($video_link, gdl_get_width($item_size), gdl_get_height($item_size));
								echo '</div>';							
								break;
								
							case "Slider" : 
							
								$slider_xml = get_post_meta( $post->ID, 'post-option-inside-thumbnail-xml', true); 
								$slider_xml_dom = new DOMDocument();
								$slider_xml_dom->loadXML($slider_xml);
								
								echo '<div class="blog-thumbnail-slider">';
								echo print_flex_slider($slider_xml_dom->documentElement, $item_size);
								echo '</div>';					
								break;
						}
						
						echo "<div class='clear'></div>";
						
						echo "<div class='single-content'>";
						echo the_content();
						echo "</div>";
						
						// About Author
						if(get_post_meta($post->ID, 'post-option-author-info-enabled', true) == "Yes"){
							echo "<div class='about-author-wrapper'>";
							echo "<div class='about-author-avartar'>" . get_avatar( get_the_author_meta('ID'), 90 ) . "</div>";
							echo "<div class='about-author-info'>";
							echo "<div class='about-author-title gdl-link-title gdl-title'>" . $translator_about_author . "</div>";
							echo get_the_author_meta('description');
							echo "</div>";
							echo "<div class='clear'></div>";
							echo "</div>";
						}
						
						// Include Social Shares
						if(get_post_meta($post->ID, 'post-option-social-enabled', true) == "Yes"){
							echo "<div class='social-share-title gdl-link-title gdl-title'>";
							echo $translator_social_share;
							echo "</div>";
							include_social_shares();
							echo "<div class='clear'></div>";
						}
					
						echo '<div class="comment-wrapper">';
						comments_template(); 
						echo '</div>';
						
						echo "</div>"; // sixteen-columns					
					
					}
					
				}
			}
		?>
			
		</div> <!-- gdl-page-item -->
		
		<?php 	
		
			get_sidebar('left');		
				
			echo "</div>"; // gdl-page-float-left	
			
			get_sidebar('right');
		?>
		
		<div class="clear"></div>
		
	</div> <!-- content-wrapper -->

<?php get_footer(); ?>