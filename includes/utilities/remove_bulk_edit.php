<?php
function removeBulkActionsInput ($actions) {
    // remove all actions
    return array();
}
add_filter ('bulk_actions-edit-' . 'guest-book-entry', 'removeBulkActionsInput' );