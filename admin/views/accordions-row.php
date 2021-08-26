<?php
	$lad_nonce = wp_create_nonce( 'load-accordion-data' . $accordion_id );
	$delete_nonce = wp_create_nonce( 'delete-accordion' . $accordion_id );
	$duplicate_nonce = wp_create_nonce( 'duplicate-accordion' . $accordion_id );
	$export_nonce = wp_create_nonce( 'export-accordion' . $accordion_id );

	$edit_url = admin_url( 'admin.php?page=grid-accordion&id=' . $accordion_id . '&action=edit' );
	$preview_url = admin_url( 'admin.php?page=grid-accordion&id=' . $accordion_id . '&action=preview' ) . '&lad_nonce=' . $lad_nonce;
	$delete_url = admin_url( 'admin.php?page=grid-accordion&id=' . $accordion_id . '&action=delete' ) . '&da_nonce=' . $delete_nonce;
	$duplicate_url = admin_url( 'admin.php?page=grid-accordion&id=' . $accordion_id . '&action=duplicate' ) . '&dua_nonce=' . $duplicate_nonce;
	$export_url = admin_url( 'admin.php?page=grid-accordion&id=' . $accordion_id . '&action=export' ) . '&ea_nonce=' . $export_nonce;
?>
<tr class="accordion-row">
	<td><?php echo esc_html( $accordion_id ); ?></td>
	<td><?php echo esc_html( $accordion_name ); ?></td>
	<td><?php echo '[grid_accordion id="' . esc_html( $accordion_id ) . '"]'; ?></td>
	<td><?php echo $accordion_created; ?></td>
	<td><?php echo $accordion_modified; ?></td>
	<td>
		<a href="<?php echo esc_url( $edit_url ); ?>"><?php _e( 'Edit', 'grid-accordion' ); ?></a> |
		<a class="preview-accordion" href="<?php echo esc_url( $preview_url ); ?>"><?php _e( 'Preview', 'grid-accordion' ); ?></a> |
		<a class="delete-accordion" href="<?php echo esc_url( $delete_url ); ?>"><?php _e( 'Delete', 'grid-accordion' ); ?></a> |
		<a class="duplicate-accordion" href="<?php echo esc_url( $duplicate_url ); ?>"><?php _e( 'Duplicate', 'grid-accordion' ); ?></a> |
		<a class="export-accordion" href="<?php echo esc_url( $export_url ); ?>"><?php _e( 'Export', 'grid-accordion' ); ?></a>
	</td>
</tr>