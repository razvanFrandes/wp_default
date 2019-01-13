<aside id="social-share">
  <h4>Share this article:</h4>
  <ul class="social-buttons">
    <li class="fb">
        <span class="sprite-social-facebook">Facebook</span>
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title();?>" class="socialite socialite-loading facebook-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank">Facebook</a>
    </li>
    <li class="tw">
        <span class="sprite-social-twitter">Twitter</span>
        <a href="http://twitter.com/share" class="socialite socialite-loading twitter-share" data-text="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>" data-via="<?php if (in_category('inside-online-learning')) { echo TWITTER_AUTHOR; } else { echo TWITTER_USERNAME; } ?>" data-related="<?php if (in_category('inside-online-learning')) { echo TWITTER_AUTHOR; } else { echo TWITTER_USERNAME; } ?>" data-count="vertical" rel="nofollow" target="_blank">Twitter</a>
    </li>
    <li class="gp">
        <span class="sprite-social-google">Google+</span>
        <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="socialite socialite-loading googleplus-one" data-size="tall" data-href="<?php the_permalink(); ?>" rel="nofollow" target="_blank">Google+</a>
    </li>
    <li class="em">
      <h4><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" class="email">Email</a></h4>
    </li>
  </ul>
</aside>
