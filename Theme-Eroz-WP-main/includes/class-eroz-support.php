<?php
Class EROZ_Support {
	public function code_analityc(){
		$code     = get_option( 'analityc_code', false );
        echo $code;
	}
}