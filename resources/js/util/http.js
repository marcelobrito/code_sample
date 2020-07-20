import axios from 'axios';

const http = axios.create ({
  baseURL: `/api/v1`,
  timeout: 15000,
  headers: {'Content-Type': 'application/json','Accept': 'application/json'},
});

http.interceptors.request.use (
  function (config) {
    const token = window.localStorage.getItem('token');
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  function (error) {
    return Promise.reject (error);
  }
);

http.interceptors.response.use(null, function(error) {
  if (error.response && error.response.status === 401) {
    window.localStorage.removeItem('token')
    Vue.router.push('/')
  }

  if(error.response && error.response.status === 422) {
      console.log(error.response);
    document.getElementsByClassName('toast-alert')[0].innerHTML =
        Object.values(error.response.data.errors).join('</br>');
    document.getElementsByClassName('toast-alert')[0].style.display = 'block';
    setTimeout(function () {
        document.getElementsByClassName('toast-alert')[0].style.display = 'none';
    },3000);
  }

  throw error
});

export default http;
