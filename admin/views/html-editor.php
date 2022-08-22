<div class="modal-overlay"></div>
<div class="modal-window-container html-editor">
	<div class="modal-window">
		<span class="close-x"></span>

		<textarea id="html-code" class="html-code" name="html_code" cols="80" rows="20"><?php echo isset( $html_content ) ? esc_textarea( stripslashes( $html_content ) ) : ''; ?></textarea>

		<?php
            $hide_info = get_option( 'grid_accordion_hide_inline_info' );

            if ( $hide_info != true ) {
        ?>
            <div class="inline-info html-editor-info">
            	<input type="checkbox" id="show-hide-info" class="show-hide-info">
				<label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'grid-accordion' ); ?></label>
				<label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'grid-accordion' ); ?></label>
				
				<div class="info-content">
	                <p><?php _e( 'In the field above you can add raw HTML content.', 'grid-accordion' ); ?></p>

					<?php
						if ( $content_type === 'posts' || $content_type === 'gallery' || $content_type === 'flickr' ) {
					?>
						<input type="checkbox" id="show-hide-dynamic-tags" class="show-hide-dynamic-tags">
						<label for="show-hide-dynamic-tags" class="show-dynamic-tags"><?php _e( 'Show dynamic tags', 'grid-accordion' ); ?></label>
						<label for="show-hide-dynamic-tags" class="hide-dynamic-tags"><?php _e( 'Hide dynamic tags', 'grid-accordion' ); ?></label>
					<?php
						}

						if ( $content_type === 'posts' ) {
					?>
							<table class="dynamic-tags">
								<tbody>
									<tr>
										<td><b>[ga_image]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s featured image, as an <i>img</i> HTML element. It accepts an optional parameter to specify the size of the image: [ga_image.thumbnail]. Accepted sizes are: <i>full</i>, <i>large</i>, <i>medium</i>, <i>thumbnail</i>. The default value is <i>full</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_src]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The URL of the post\'s featured image. It accepts an optional parameter to specify the size of the image: [ga_image_src.thumbnail]. Accepted sizes are: <i>full</i>, <i>large</i>, <i>medium</i>, <i>thumbnail</i>. The default value is <i>full</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_alt]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The <i>alt</i> text of the post\'s featured image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_title]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The title of the post\'s featured image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_description]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The description of the post\'s featured image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_caption]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The caption of the post\'s featured image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_title]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s title.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_link]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s link, as an <i>anchor</i> HTML element, with the post\'s title as the text of the link.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_link_url]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s link.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_date]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s date.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_excerpt]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s excerpt.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_content]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The post\'s content.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_category]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The first category that the post is assigned to.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_custom.<i>name</i>]</b></td>
										<td> - </td>
										<td><p><?php _e( 'Returns the value from a custom field. The <i>name</i> parameter indicates the name of the custom field.', 'grid-accordion' ); ?></p></td>
									</tr>
								</tbody>
							</table>
	            	<?php
	            		} else if ( $content_type === 'gallery' ) {
	            	?>
	            			<table class="dynamic-tags">
								<tbody>
									<tr>
										<td><b>[ga_image]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The gallery image, as an <i>img</i> HTML element. It accepts an optional parameter to specify the size of the image: [ga_image.thumbnail]. Accepted sizes are: <i>full</i>, <i>large</i>, <i>medium</i>, <i>thumbnail</i>. The default value is <i>full</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_src]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The URL of the gallery image. It accepts an optional parameter to specify the size of the image: [ga_image_src.thumbnail]. Accepted sizes are: <i>full</i>, <i>large</i>, <i>medium</i>, <i>thumbnail</i>. The default value is <i>full</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_alt]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The <i>alt</i> text of the gallery image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_title]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The title of the gallery image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_description]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The description of the gallery image.', 'grid-accordion' ); ?></p></td>
									</tr>
								</tbody>
							</table>
	            	<?php
	            		} else if ( $content_type === 'flickr' ) {
	            	?>
	            			<table class="dynamic-tags">
								<tbody>
									<tr>
										<td><b>[ga_image]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The Flickr image, as an <i>img</i> HTML element. It accepts an optional parameter to specify the size of the image: [ga_image.thumbnail]. Accepted sizes are: <i>full</i>, <i>large</i>, <i>medium</i>, <i>thumbnail</i>. The default value is <i>full</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_src]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The URL of the Flickr image. It accepts an optional parameter to specify the size of the image: [ga_image_src.thumbnail]. Accepted sizes are: <i>square</i>, <i>thumbnail</i>, <i>small</i>, <i>medium</i>, <i>medium_640</i>, <i>large</i>. The default value is <i>medium</i>.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_description]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The description of the Flickr image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_image_link]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The link of the Flickr image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_date]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The date of the Flickr image.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_username]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The username of the image\'s owner.', 'grid-accordion' ); ?></p></td>
									</tr>
									<tr>
										<td><b>[ga_user_link]</b></td>
										<td> - </td>
										<td><p><?php _e( 'The link to the profile of the image\'s owner.', 'grid-accordion' ); ?></p></td>
									</tr>
								</tbody>
							</table>
	            	<?php
	            		}
	            	?>
	            </div>
            </div>
        <?php
            }
        ?>
	</div>
</div>