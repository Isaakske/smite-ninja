/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import $ from "jquery";
import Cookies from 'js-cookie';

$('body')
    .on('change', '#darkModeSwitch', function () {
        const isDark = $(this).is(':checked');
        const $html = $('html');

        $html.toggleClass('light', !isDark);
        $html.toggleClass('dark', isDark);
        Cookies.set('theme', isDark ? 'dark' : 'light', { expires: 365 });
    })
;

if ($('[data-poll="1"]').length) {
    const handler = setInterval(function () {
        $.get(window.location, { poll: 1 }, function (response) {
            if (response.hasOwnProperty('finished') && !response.finished) {
                return;
            }

            $('body div:first').html(response);
            clearInterval(handler);
        });
    }, 10000);
}
