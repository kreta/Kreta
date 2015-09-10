/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import {Config} from '../config';

export class Project extends Backbone.Model {
  urlRoot() {
    return Config.baseUrl + '/projects';
  }

  defaults () {
    return {
      name: '',
      short_name: '',
      participants: []
    };
  }

  toString () {
    return this.get('name');
  }

  getUserRole(user) {
    var role = null;
    this.get('participants').forEach(function(participant) {
      if(participant.user.id == user.id) {
        role = participant.role;
      }
    });

    return role;
  }

  toJSON(options) {
    var data = _.clone(this.attributes);

    if (typeof(options) !== 'undefined' && options.parse) {
      data = _.omit(data, 'id');
    }

    return data;
  }
}
