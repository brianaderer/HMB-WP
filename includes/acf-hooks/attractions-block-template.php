<?php
// Check if block data is available.
if (!isset($block)) {
	return;
}

// You can use $block['id'] to add unique attributes to the block's HTML markup.
$block_id = $block['id'];

// Fetch ACF fields related to this block. Replace 'field_name' with your actual field names.
$example_field = get_field('field_name') ?: 'Default value';

// Add your custom block markup below.
?>

<div id="<?php echo esc_attr($block_id); ?>" class="attractions-block">
	<h2>Attractions Block</h2>
	<p><?php echo esc_html($example_field); ?></p>
	<!-- Add more fields and markup as needed -->
</div>
