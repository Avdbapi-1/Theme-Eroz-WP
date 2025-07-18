<?php
$id       = get_the_ID();
$data     = new BCT_DataPost;
$duration = $data->duration($id);
$trailer  = $data->trailer($id);
$poster   = $data->poster($id);
$thumbs   = get_post_meta(get_the_ID(), 'thumbs', false); ?>



<article <?php if ($trailer) { echo 'data-preview="' . $trailer . '"'; } if ($thumbs) { echo 'data-thumbs="' . $thumbs[0] . '" data-thumbsmax="' . count($thumbs) . '"'; } ?> <?php post_class('loop-post'); ?>>
    
    <header class="entry-header">
        <a href="<?php the_permalink(); ?>">
        <h2 class="entry-title"> <?php echo wp_trim_words(get_the_title(), 5, '...'); ?></h2>
            <figure data-url="<?php echo $trailer; ?>" class="post-thumbnail image-articles fa-play-circle far">
                <?php echo $poster; ?>
                <div class="pst-rt"><div class="EzVotes">
                <div class="numper"><strong><?php echo vote_post_percent($id)['percent'] ?>%</strong></div>
            </div></div>
            </figure>
        </a>
        <p class="entry-meta">
            <?php if (get_post_meta(get_the_ID(), 'views', true)) { ?>
                <span class="Views fa-eye"><?php echo get_post_meta(get_the_ID(), 'views', true); ?></span>
            <?php } ?> 

            <?php if($duration) { echo '<span class="Time fa-clock">'. $duration .'</span>'; } ?>

        </p>
    </header>

</article>