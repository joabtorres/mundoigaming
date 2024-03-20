<?php
if (strpos(url(), "localhost")) {
    /**
     * CSS
     */
    $minCSS = new \MatthiasMullie\Minify\CSS();
    //boostrap
    $minCSS->add(__DIR__ . "/../../shared/css/bootstrap/bootstrap.min.css");
    // fontawesome
    $minCSS->add(__DIR__ . "/../../shared/css/fontawesome/fontawesome.min.css");
    $minCSS->add(__DIR__ . "/../../shared/css/fontawesome/brands.min.css");
    $minCSS->add(__DIR__ . "/../../shared/css/fontawesome/regular.min.css");
    $minCSS->add(__DIR__ . "/../../shared/css/fontawesome/solid.min.css");
    //jquery-ui (calendar)
    $minCSS->add(__DIR__ . "/../../shared/css/jquery-ui/jquery-ui.min.css");
    //select2
    $minCSS->add(__DIR__ . "/../../shared/css/select2/select2.min.css");
    $minCSS->add(__DIR__ . "/../../shared/css/mCustomScrollbar.min.css");

    //theme css
    $cssDir = scandir(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/css");
    foreach ($cssDir as $css) {
        $cssFile = __DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/css/{$css}";
        if (is_file($cssFile) && pathinfo($cssFile)['extension'] == "css") {
            $minCSS->add($cssFile);
        }
    }

    //Minify CSS
    $minCSS->minify(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/styles_minify.css");

    /**
     * JS
     */
    $minJS = new \MatthiasMullie\Minify\JS();
    $minJS->add(__DIR__ . "/../../shared/js/jquery-3.1.1.min.js");
    $minJS->add(__DIR__ . "/../../shared/js/jquery.form.js");
    $minJS->add(__DIR__ . "/../../shared/js/jquery-ui/jquery-ui.min.js");
    $minJS->add(__DIR__ . "/../../shared/js/select2/select2.min.js");
    $minJS->add(__DIR__ . "/../../shared/js/bootstrap/bootstrap.min.js");
    $minJS->add(__DIR__ . "/../../shared/js/maskedinput/jquery.maskedinput.min.js");
    $minJS->add(__DIR__ . "/../../shared/js/mCustomScrollbar.min.js");

    //themes js
    $jsDir = scandir(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/js");
    foreach ($jsDir as $js) {
        $jsFile = __DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/js/{$js}";
        if (is_file($jsFile) && pathinfo($jsFile)['extension'] == "js") {
            $minJS->add($jsFile);
        }
    }

    //Minify JS
    $minJS->minify(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/assets/scripts_minify.js");
}
