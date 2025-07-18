<?php
class EROZ_public_ajax {
    public function change_player_eroz() {
          if( isset( $_POST[ 'action' ] ) ) {
            
            $id          = $_POST['ide'];
            $key         = $_POST['key'];
            $input_video = get_option( 'eroz_meta_video', false );
            $tubeace = get_option('enable_tubeace');
            $videos      = array();

            if($tubeace == 1){
                $field_tubeace = get_post_meta( $id, 'video_url', true );
                $url = get_post_meta( $id, 'url', true );
                $site = get_post_meta( $id, 'site', true );
                $embed_ace = get_post_meta($id, 'embed_code', true);
                $video_0 = false;
                //xvideos
                if (strpos($field_tubeace, 'www.xvideos.com') !== false) {
        
                    $field_tubeace_array = explode('/', $field_tubeace);
                    $field_tubeace_array_reverse = array_reverse($field_tubeace_array);
                    $id_xvideos_full = $field_tubeace_array_reverse[1];
                    $id_xvideos = str_replace('video', '', $id_xvideos_full);
                    $video_0 = '<iframe src="https://www.xvideos.com/embedframe/'.$id_xvideos.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                    
                } //pornhub
                elseif(strpos($url, 'www.pornhub.com') !== false) {
                    $url_id = get_post_meta( $id, 'video_id', true );
                    $video_0 = '<iframe src="https://www.pornhub.com/embed/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                }  //xhamster
                elseif(strpos($site, 'xhamster.com') !== false) {
                    $url_id = get_post_meta( $id, 'video_id', true );
                    $video_0 = '<iframe src="https://xhamster.com/xembed.php?video='.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                } //youporn
                elseif(strpos($site, 'youporn.com') !== false) {
                    $url_id = get_post_meta( $id, 'video_id', true );
                    $video_0 = '<iframe src="https://www.youporn.com/embed/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                } //tube8.com
                elseif(strpos($site, 'tube8.com') !== false) {
                    $url_id = get_post_meta( $id, 'video_id', true );
                    $video_0 = '<iframe src="https://www.tube8.com/embed/category/title/'.$url_id.'" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                } //redtube
                elseif(strpos($site, 'redtube.com') !== false) {
                    $url_id = get_post_meta( $id, 'video_id', true );
                    $video_0 = '<iframe src="https://embed.redtube.com/?id='.$url_id.'&bgcolor=000000" frameborder="0" width="510" height="400" scrolling="no" allowfullscreen="allowfullscreen"></iframe>';
                } //sunporn
                elseif(strpos($embed_ace, 'sunporno.com') !== false) {
                    $video_0 = $embed_ace;
                } 

                if (strpos($video_0, '[fvplayer') !== false) { $video_0 = do_shortcode($video_0); }
                if($video_0){$videos[] = $video_0;}
            }
            $video_1     = get_post_meta( $id, $input_video, true );
            $video_2     = get_post_meta( $id, 'video_optional_1', true );
            $video_3     = get_post_meta( $id, 'video_optional_2', true );
            $video_4     = get_post_meta( $id, 'video_optional_3', true );
            $video_5     = get_post_meta( $id, 'video_optional_4', true );
          
			if (strpos($video_1, '[fvplayer') !== false) { $video_1 = do_shortcode($video_1); }
			if (strpos($video_2, '[fvplayer') !== false) { $video_2 = do_shortcode($video_2); }
			if (strpos($video_3, '[fvplayer') !== false) { $video_3 = do_shortcode($video_3); }
			if (strpos($video_4, '[fvplayer') !== false) { $video_4 = do_shortcode($video_4); }
			if (strpos($video_5, '[fvplayer') !== false) { $video_5 = do_shortcode($video_5); }
			  
            if($video_1){$videos[] = $video_1;}
            if($video_2){$videos[] = $video_2;}
            if($video_3){$videos[] = $video_3;}
            if($video_4){$videos[] = $video_4;}
            if($video_5){$videos[] = $video_5;}
            
            if(count($videos) > 0){
                $vi = $videos[$key];
            }
    
            $res = [
                'res'   => 'conexion',
                'video' => $vi,
            ];
            echo json_encode($res);
            wp_die();
          }
    }
    public function eroz_send_report() {
        check_ajax_referer('eroz_seg', 'nonce');
        if( isset( $_POST[ 'action' ] ) ) {
            $id_post = $_POST['id_post'];
            $reason = $_POST['reason'];
            add_post_meta( $id_post, '_repor', $reason);
            $res = [
                'resultado' => $reason 
            ];
            echo json_encode($res);
            wp_die();
        }
    }
    public function eroz_send_vote() {
        check_ajax_referer('eroz_seg', 'nonce');
        if( isset( $_POST[ 'action' ] ) ) {
            $id_post = $_POST['id_post'];
            $type = $_POST['type'];
            if($type == 'like') {
                $currentvotes = get_post_meta($id_post, 'like', true);
                $currentvotes = $currentvotes + 1;
                update_post_meta($id_post, 'like', $currentvotes);
            } elseif($type == 'unlike') {
                $currentvotes = get_post_meta($id_post, 'unlike', true);
                $currentvotes = $currentvotes + 1;
                update_post_meta($id_post, 'unlike', $currentvotes);
            }
            /*GET VALUES*/
            $like = get_post_meta( $id_post, 'like', true );
            $unlike = get_post_meta( $id_post, 'unlike', true );
            $total = $like + $unlike;
            if($total == 0) {
                $percent = 0 . '%';
            } else {
                $percent = round(($like / $total) * 100) . '%';
            }
            $res = [
                'total' => $total,
                'percent' => $percent
            ];
            echo json_encode($res);
            wp_die();
        }
    }
}