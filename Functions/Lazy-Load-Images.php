<?php
/*
  Title: Lazy Load Images
  Category: Bloat Remover and Speed Optimization
  Description: Add description here
*/

function add_lazy_loading_to_images($content) {
    // Check if the content contains any image tags
    if (strpos($content, '<img') !== false) {
        // Add the loading attribute to all img tags
        $content = preg_replace('/<img(.*?)>/', '<img$1 loading="lazy">', $content);
    }
    return $content;
}

add_filter('the_content', 'add_lazy_loading_to_images');

// Add JavaScript to create a fade-in effect for lazy-loaded images
function add_lazy_loading_fade_in_script() {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyImages = document.querySelectorAll("img[loading=\'lazy\']");
            if ("IntersectionObserver" in window) {
                var lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var lazyImage = entry.target;
                            lazyImage.style.transition = "opacity 300ms ease-in-out";
                            lazyImage.style.opacity = 1;
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                    lazyImage.style.opacity = 0;
                });
            }
        });
        </script>';
}

add_action('wp_footer', 'add_lazy_loading_fade_in_script');


?>
