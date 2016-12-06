export default {
  login: (email, password) => {
    return new Promise((resolve, reject) => {
      email === 'valid@email.com' && password === 'password' ?
        resolve(new Promise(resolve => resolve({token: 'token'}))) :
        reject(new Promise(resolve => resolve()))
    })
  },
  logout: () => {
    return new Promise((resolve) => {
      resolve();
    })
  }
};
