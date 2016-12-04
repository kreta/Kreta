export default {
  login: (username, password) => {
    return new Promise((resolve, reject) => {
      username === 'username' && password === 'password' ?
        resolve('token') : null
    })
  },
  logout: () => {
    return new Promise((resolve, reject) => {
        resolve();
    })
  }
};
