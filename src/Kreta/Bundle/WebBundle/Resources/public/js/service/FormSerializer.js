/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import ReactDOM from 'react-dom';

function _forEach(array, callback, scope) {
  for (let i = 0; i < array.length; i++) {
    callback.call(scope, array[i], i);
  }
}

class FormSerializerService {
  static serialize(formRef) {
    const
      formData = {},
      form = ReactDOM.findDOMNode(formRef);

    _forEach(form, (input) => {
      if (input.type === 'file') {
        if (input.files.length > 0) {
          formData[input.name] = input.files[0];
        }
      } else {
        formData[input.name] = input.value;
      }
    });

    return formData;
  }
}

export default FormSerializerService;
