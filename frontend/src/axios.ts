import axios from "axios";

const workApi = axios.create({
  baseURL: "/api/v1",
  headers: { 
    Accept: "application/json",
    'Content-Type': 'application/json'
  },
  withCredentials: true,
});

export default workApi
