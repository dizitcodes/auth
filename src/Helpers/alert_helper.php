<?php

function setAlert($icon, $title, $html = null, $footer = null)
{
    $session = \Config\Services::session();
    $session->setFlashdata('alert', [
        'type' => 'default',
        'icon' => $icon,
        'title' => $title,
        'html' => $html,
        'footer' => $footer
    ]);
}
function setToast($icon, $title, $position = null)
{
    $session = \Config\Services::session();
    $session->setFlashdata('alert', [
        'type' => 'toast',
        'icon' => $icon,
        'title' => $title,
        'position' => $position ?? 'top-end',
    ]);
}
function getAlert()
{
    $session = \Config\Services::session();
    $alert = $session->getFlashdata('alert');
    if ($alert) :
        if (($alert['type'] ?? null) == 'toast') :
            $return = '<script>';
            $return .= "Toast.fire({icon: '{$alert['icon']}',title: '{$alert['title']}', position: '{$alert['position']}'})";
            $return .= '</script>';
            return $return;
        else :
            return "<script>alertDefault('{$alert['icon']}', '{$alert['title']}', '{$alert['html']}', '{$alert['footer']}')</script>";
        endif;
    else :
        return '<!-- alerts -->';
    endif;
}

function displayAlert($icon, $title, $html = null, $footer = null)
{
    $session = \Config\Services::session();
    $session->setTempdata('tempAlert', "<script>alertDefault('{$icon}', '{$title}', '{$html}', '{$footer}')</script>", 0.5);
}


/*
const Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000,
	timerProgressBar: true,
	didOpen: (toast) => {
		toast.addEventListener('mouseenter', Swal.stopTimer)
		toast.addEventListener('mouseleave', Swal.resumeTimer)
	}
})

function alertDefault(icon, title, text = null, footer = null) {
	Swal.fire({
		icon: icon,
		title: title,
		html: text,
		footer: footer
	})
}

function alertToast(icon, title) {
	Toast.fire({
		icon: icon,
		title: title
	})
}
*/