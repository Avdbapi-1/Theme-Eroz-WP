<?php 
class BCT_DataPost {

	public function duration($id){
		$second_time    = false;
		$duration_field = get_option('eroz_meta_duration', true );
		$duration       = get_post_meta( $id, $duration_field, true );
		
		if($duration) $second_time = secondtotime($duration);
		
		return $second_time;
	}

	public function trailer($id){
		$trailer_field = get_option('eroz_meta_video_trailer', true);
		$trailer       = get_post_meta($id, $trailer_field, true);
		return $trailer;
	}

	public function poster($id){
		$src = get_post_meta($id, 'eroz_meta_src', true);
		$img = (has_post_thumbnail($id)) ? '<img loading="lazy" class="lazys" src="'. get_the_post_thumbnail_url($id, 'thumbnail').'" alt="'. get_the_title($id).'">' : '<img loading="lazy" class="lazys" src="'. $src .'" alt="'. get_the_title($id).'">';
		return $img;
	}

}