/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

export class FormSerializerService {
  static serialize($form, model = null) {
    var formData = {};
    $.each($form.serializeArray(), function () {
      formData[this.name] = this.value;
    });

    if(model) {
      //Remove defaults to avoid issues with the API in case we are using a model
      model = model.extend({defaults: {}});
      return new model(formData);
    }

    //Key value form date is returned in case we are not using a model
    return formData;
  }
}
