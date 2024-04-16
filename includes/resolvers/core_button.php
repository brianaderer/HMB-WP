<?php
add_action('graphql_register_types', function () {
    register_graphql_field('CoreButton', 'href', [
        'type' => 'String',
        'description' => 'Custom attributes for the paragraph block',
        'resolve' => function ($root, $args, $context, $info) {
            // Extract attributes from the block

            $href = extract_href( $root['innerHTML'] );
            // Process and return your custom attributes
            // For example, returning a JSON string of attributes
            return $href;
        },
    ]);
});

function extract_href($html) {
    // Create a new DOMDocument instance
    $dom = new DOMDocument();

    // Suppress errors due to malformed HTML
    libxml_use_internal_errors(true);

    // Load the HTML content
    $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    // Clear the libxml error buffer
    libxml_clear_errors();

    // Use DOMXPath to query the document
    $xpath = new DOMXPath($dom);

    // Query to find <a> elements within .wp-block-button__link
    $links = $xpath->query("//a[@class='wp-block-button__link wp-element-button']");

    // If links are found
    if ($links->length > 0) {
        // Assuming the first <a> tag is the required one
        $href = $links->item(0)->getAttribute('href');
        return $href;
    }

    // Return false if no link is found
    return false;
}

