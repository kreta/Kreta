/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class FormSerializerService {
  static serialize($form, model) {
    var formData = {};
    $.each($form.serializeArray(), function () {
      formData[this.name] = this.value;
    });

    //Remove defaults to avoid issues with the API
    model = model.extend({defaults: {}});
    return new model(formData);
  }
}
