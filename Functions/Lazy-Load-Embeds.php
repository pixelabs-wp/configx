<?php
/*
  Title: Lazy Load Embeds
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function add_lazy_loading_to_embeds($content) {
    // Check if the content contains any embed (iframe) tags
    if (strpos($content, '<iframe') !== false) {
        // Add the loading attribute to all iframe tags
        $content = preg_replace('/<iframe(.*?)>/', '<iframe$1 loading="lazy">', $content);
    }
    return $content;
}

add_filter('the_content', 'add_lazy_loading_to_embeds');

// Add JavaScript to create a fade-in effect for lazy-loaded embeds
function add_lazy_loading_fade_in_script() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyEmbeds = document.querySelectorAll("iframe[loading=\'lazy\']");
            if ("IntersectionObserver" in window) {
                var lazyEmbedObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var lazyEmbed = entry.target;
                            lazyEmbed.style.transition = "opacity 300ms ease-in-out";
                            lazyEmbed.style.opacity = 1;
                            lazyEmbedObserver.unobserve(lazyEmbed);
                        }
                    });
                });
                lazyEmbeds.forEach(function(lazyEmbed) {
                    lazyEmbedObserver.observe(lazyEmbed);
                    lazyEmbed.style.opacity = 0;
                });
            }
        });
        </script>';
}

add_action('wp_footer', 'add_lazy_loading_fade_in_script');


?>