import axios from 'axios';

export function getFrom (url) {
    axios.get(url)
    .then(function (res) {
        return res;
    })
    .catch(function (err) {
        return err;
    })
}

export function postFrom (url, param) {
    axios.get(url, {
    params: { param }
  })
    .then(function (res) {
        return res;
    })
    .catch(function (err) {
        return err;
    })
}