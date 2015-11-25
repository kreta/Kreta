/*
 * This file is part of the Kreta package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import AppDispatcher from './../dispatcher/AppDispatcher';
import AppConstants from '../constants/AppConstants';

export function addIssue() {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.NEW_ISSUE
  });
}

export function saveIssue(issue) {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.SAVE_ISSUE,
    issue: issue
  });
}

export function addProject() {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.NEW_PROJECT
  });
}

export function saveProject(project) {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.SAVE_PROJECT,
    project: project
  });
}

export function updateProfile() {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.UPDATE_PROFILE
  });
}

export function saveProfile(user) {
  AppDispatcher.handleViewAction({
    actionType: AppConstants.SAVE_PROFILE,
    user: user
  });
}
