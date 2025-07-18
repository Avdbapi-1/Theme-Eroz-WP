<?php
class EROZ_admin_ajax {
    public function eroz_activate_license() {
        check_ajax_referer('eroz_seg', 'nonce');
        if( isset( $_POST[ 'action' ] ) ) {
            $store_url = 'https://torothemes.com';
            $item_id = '1635';
            $license = $_POST['license'];
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license,
                'item_id' => $item_id,
                'url' => home_url()
            );
            $response = wp_remote_post( $store_url, array( 'body' => $api_params, 'timeout' => 15, 'sslverify' => false ) );
            $license_data = json_decode( wp_remote_retrieve_body( $response ) );
            if($license_data->license == 'valid') {
                update_option( 'license', $license );
            }
            $res = [
                'resultado' => $license_data->license
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    public function eroz_clean_report() {
        check_ajax_referer('eroz_seg', 'nonce');
        if( isset( $_POST[ 'action' ] ) ) {
            $id = $_POST['id'];
            delete_post_meta( $id, '_repor' );
            $res = [
                'resultado' => 'correct'
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    public function eroz_save_metabox() {
        check_ajax_referer('eroz_seg', 'nonce');
        if( isset( $_POST[ 'action' ] ) ) {
            $meta_video = $_POST['meta_video'];
            $meta_duration = $_POST['meta_duration'];
            update_option( 'eroz_meta_video', $meta_video );
            update_option( 'eroz_meta_duration', $meta_duration );
            $res = [
                'resultado' => 'correct'
            ];
            echo json_encode($res);
            wp_die();
        }
    }
}