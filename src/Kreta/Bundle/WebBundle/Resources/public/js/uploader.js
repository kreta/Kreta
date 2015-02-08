/**
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

$(document).ready(function () {
    var $photo, $image;

    $photo = $('#kreta_user_user_type_photo');
    $image = $('#kreta_project_project_type_image');

    $photo.on('change', function () {
        $('.kreta-image-preview')[0].src = window.URL.createObjectURL(this.files[0]);
    });
    $image.on('change', function() {
        $('.kreta-image-preview')[0].src = window.URL.createObjectURL(this.files[0]);
    });
});
