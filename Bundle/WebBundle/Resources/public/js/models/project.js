/*
 * This file belongs to Kreta.
 * The source code of application includes a LICENSE file
 * with all information about license.
 *
 * @author benatespina <benatespina@gmail.com>
 * @author gorkalaucirica <gorka.lauzirika@gmail.com>
 */

import Backbone from 'backbone';
import {Config} from '../config';

export class Project extends Backbone.Model {
  urlRoot() {
    return `${Config.baseUrl}/projects`;
  }

  defaults() {
    return {
      name: '',
      short_name: '',
      participants: [],
      issue_priorities: null,
      issue_types: null,
      statuses: null
    };
  }

  toString() {
    return this.get('name');
  }

  getUserRole(user) {
    var role = null;
    this.get('participants').forEach((participant) => {
      if (participant.user.id === user.id) {
        role = participant.role;
      }
    });

    return role;
  }

  toJSON(options) {
    var data = _.clone(this.attributes);

    if (typeof options !== 'undefined' && options.parse) {
      data = _.omit(data, 'id');
    }

    return data;
  }

  get(attr) {
    if (this.attributes[attr] === null
      && typeof this.attributes._links !== 'undefined'
      && typeof this.attributes._links[attr] !== 'undefined') {
      this.attributes[attr] = [];
      Backbone.$.get(this.attributes._links[attr].href, (data) => {
        this.set(attr, data);
      });
    }

    return this.attributes[attr];
  }
}
