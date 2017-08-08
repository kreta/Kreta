/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import {DefaultNetworkLayer} from 'react-relay';
import RelayMutationRequest from 'react-relay/lib/RelayMutationRequest';
import RelayQueryRequest from 'react-relay/lib/RelayQueryRequest';

import UserActions from './../../actions/User';

class GraphQl {
  constructor() {
    if (this.constructor.name === 'GraphQl') {
      throw new TypeError(
        'GraphQl is an abstract class, it cannot be instantiate directly',
      );
    }

    this.accessToken = () => localStorage.token;

    this.issetToken = () => typeof this.accessToken() !== 'undefined';

    this.uri = () => `${this.baseUrl()}?access_token=${this.accessToken()}`;

    this.isRelayQueryRequest = query => {
      if (!(query instanceof RelayQueryRequest)) {
        throw new TypeError(
          'Given query must be a collection of RelayQueryRequest or a single RelayQueryRequest',
        );
      }
    };

    this.isRelayMutationRequest = mutation => {
      if (!(mutation instanceof RelayMutationRequest)) {
        throw new TypeError('Given mutation must be a RelayMutationRequest');
      }
    };

    this.relayNetworkLayer = () => new DefaultNetworkLayer(this.uri());

    this.buildGraphQlResponse = (response, dispatch) =>
      response.catch(error => {
        if (
          typeof error.source !== 'undefined' &&
          error.source.errors.length > 0
        ) {
          return;
        }
        this.getUncontrolledErrors(error, dispatch);
      });

    this.getUncontrolledErrors = (error, dispatch) => {
      if (__DEV__) {
        return console.error(error);
      }

      dispatch(UserActions.logout());
    };
  }

  baseUrl() {
    throw new Error(
      '"baseUrl" is an abstract method that expects to be implemented by children classes',
    );
  }

  query(query, dispatch) {
    if (false === this.issetToken()) {
      return;
    }
    if (query instanceof Array) {
      for (const variable of query) {
        this.isRelayQueryRequest(variable);
        this.buildGraphQlResponse(variable, dispatch);
      }
    } else {
      this.isRelayQueryRequest(query);
      this.buildGraphQlResponse(query, dispatch);
      query = [query];
    }

    return this.relayNetworkLayer().sendQueries(query);
  }

  mutation(mutation, dispatch) {
    if (false === this.issetToken()) {
      return;
    }
    this.isRelayMutationRequest(mutation);
    this.buildGraphQlResponse(mutation, dispatch);

    return this.relayNetworkLayer().sendMutation(mutation);
  }
}

export default GraphQl;
