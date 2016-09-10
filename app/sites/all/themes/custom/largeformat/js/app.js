(function($) {

  Drupal.behaviors.skrollr = {
    attach: function(context, settings) {
      if (!Modernizr.touch) {
        skrollr.init({
          forceHeight: false,
          smoothScrolling: false,
        });
      }
    }
  }

  Drupal.behaviors.stickyHeader = {
    attach: function(context, settings) {
      var $stickyElement = $('.post--full .post-header');
      var sticky;

      if ($stickyElement.length) {
        sticky = new Waypoint.Sticky({
          element: $stickyElement[0],
          stuckClass: 'post-header--stuck',
          offset: 83,
          wrapper: '<div class="sticky-wrapper waypoint" />'
        });
      }
    }
  }

  Drupal.behaviors.menuToggle = {
    attach: function(context, settings) {
      $('.main-menu__toggle').click(function() {
        console.log('clicked');
        $('.main-menu .nav__list').slideToggle('fast');
        return false;
      });
    }
  }

}(jQuery));