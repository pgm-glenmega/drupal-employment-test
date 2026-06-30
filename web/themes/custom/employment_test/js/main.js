(function (Drupal, once) {
  'use strict';

  Drupal.behaviors.employmentTestHeader = {
    attach(context) {
      once('employment-test-header', '.site-header', context).forEach((header) => {
        const scrollThreshold = 40;
        let ticking = false;

        const updateHeader = () => {
          header.classList.toggle(
            'is-scrolled',
            window.scrollY > scrollThreshold,
          );

          ticking = false;
        };

        const handleScroll = () => {
          if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
          }
        };

        updateHeader();

        window.addEventListener('scroll', handleScroll, {
          passive: true,
        });
      });
    },
  };
})(Drupal, once);
