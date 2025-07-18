<?php
class BCT_i18n {
    public function load_theme_textdomain() {
        $textdomain = "bct-opt";
        load_theme_textdomain(
            $textdomain,
            false,
            EROZ_DIR_PATH . 'lang'
        );
        $locale = apply_filters( 'theme_locale', is_admin() ? get_user_locale() : get_locale(), $textdomain );
        load_textdomain( $textdomain, get_theme_file_path( "lang/$textdomain-$locale.po" ) );
    }
}