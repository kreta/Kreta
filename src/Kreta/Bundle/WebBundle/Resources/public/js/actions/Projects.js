import ActionTypes              from '../constants/ActionTypes';
import { routeActions }       from 'react-router-redux';

const Actions = {
  fetchProjects: () => {
    return dispatch => {
      dispatch({type: ActionTypes.PROJECTS_FETCHING});

      // Simulate API call
      setTimeout(() => {
        dispatch({
          type: ActionTypes.PROJECTS_RECEIVED,
          projects: [{
            id: 0,
            name: "Test 0"
          }, {
            id: 1,
            name: "Test 1"
          }]
        });
      }, 200);
    };
  },
  showCreateForm: () => {
    return dispatch => {
      dispatch(routeActions.push('/project/new'));
      dispatch({
        type: ActionTypes.PROJECTS_CREATE_FORM_SHOW
      });
    }
  }
};

export default Actions;
