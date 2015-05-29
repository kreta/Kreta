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

    return new model(formData);
  }
}
