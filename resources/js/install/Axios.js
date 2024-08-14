import axios from "axios";

window.axios = axios;

const token = document.querySelector('meta[name="csrf-token"]').content;

axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
