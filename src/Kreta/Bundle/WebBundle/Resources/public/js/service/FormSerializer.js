/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import $ from 'jquery';

class FormSerializerService {
  static serialize(formRef) {
    var formData = {},
        $form = $(formRef);

    $.each($form.serializeArray(), function () {
      formData[this.name] = this.value;
    });

    $.each($form.find(':file'), function () {
      if (this.files.length > 0) {
        formData[this.name] = this.files[0];
      }
    });

    return formData;
  }
}

export default FormSerializerService;
