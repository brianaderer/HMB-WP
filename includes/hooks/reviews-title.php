<?php
function add_title_to_review( array $data, array $postarr, array $unsanitized_postarr, bool $update ):array {
	if( $postarr['post_type'] == 'review' ):
		$fields = get_fields($postarr['ID']);
		$title = $fields['reviewers_name'] . ' - ' . $fields['source']['label'] . ' - ' . $fields['date'];
		$data['post_title'] = $title;
		logger( $data['post_date'] );
		$date = date( 'Y-m-d H:i:s', strtotime( $fields['date'] ) );
		$data['post_date'] = $date;
	endif;
	return $data;
}
add_action( 'wp_insert_post_data', 'add_title_to_review', 10, 4 );
