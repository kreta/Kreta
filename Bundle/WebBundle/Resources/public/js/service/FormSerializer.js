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

export class FormSerializerService {
  static serialize($form, model = null) {
    var formData = {}, Model;

    $.each($form.serializeArray(), function () {
      formData[this.name] = this.value;
    });

    $.each($form.find(':file'), function () {
      formData[this.name] = this.files[0];
    });

    if (model) {
      // Remove defaults to avoid issues with API in case we are using a model
      Model = model.extend({defaults: {}});
      return new Model(formData);
    }

    // Key value form date is returned in case we are not using a model
    return formData;
  }
}
