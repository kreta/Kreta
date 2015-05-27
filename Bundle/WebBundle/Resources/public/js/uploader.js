/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

(function ($) {
  'use strict';

  $(document).ready(function () {
    var $photo, $image, $preview;

    $photo = $('#kreta_user_user_type_photo');
    $image = $('#kreta_project_project_type_image');
    $preview = $('.kreta-image-preview');

    $photo.on('change', function () {
      $preview[0].src = window.URL.createObjectURL(this.files[0]);
    });
    $image.on('change', function () {
      $preview[0].src = window.URL.createObjectURL(this.files[0]);
    });
  });
}(jQuery));
