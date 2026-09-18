<?php
/**
 * Bootstrap-modal wrapper styled with the shared design system (used for
 * delete-confirm, order-detail and customer-detail modals in the dashboard).
 */
if (!function_exists('skoolyst_modal_open')) {
    function skoolyst_modal_open(string $id, string $title, string $size = ''): string
    {
        $sizeClass = $size ? " modal-{$size}" : '';
        return '<div class="modal fade" id="' . clean($id) . '" tabindex="-1" aria-hidden="true">'
            . '<div class="modal-dialog' . $sizeClass . ' modal-dialog-centered">'
            . '<div class="modal-content">'
            . '<div class="modal-header"><h5 class="modal-title">' . clean($title) . '</h5>'
            . '<button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>'
            . '<div class="modal-body">';
    }
}

if (!function_exists('skoolyst_modal_footer')) {
    function skoolyst_modal_footer(string $innerHtml): string
    {
        return '</div><div class="modal-footer">' . $innerHtml . '</div>';
    }
}

if (!function_exists('skoolyst_modal_close')) {
    function skoolyst_modal_close(): string
    {
        return '</div></div></div></div>';
    }
}
