import axios, { AxiosRequestConfig, AxiosResponse } from "axios";
import JwtService from "./JwtService";

const baseUrl = process.env.parsed.VUE_APP_API_URL
export class ApiService {

  constructor() {
    axios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${JwtService.getToken()}`;
    axios.defaults.headers.common["Accept"] = "application/json";
    axios.interceptors.response.use(
      (response) => {
        return response;
      },
      (error) => {
        if (error.response.status === 401) {
          //place your reentry code
          console.log("errp");
        }
        return error;
      }
    );
  }

  public static query(
    resource: string,
    params: AxiosRequestConfig
  ): Promise<AxiosResponse> {
    axios.defaults.headers.common = {
      Authorization: `Bearer ${JwtService.getToken()}`,
      Accept: `application/json`,
    };

    return axios.get(baseUrl + `${resource}`, { params: params });
  }

  public static post(
    resource: string,
    params: AxiosRequestConfig
  ): Promise<AxiosResponse> {
     axios.defaults.headers.common = {
      Authorization: `Bearer ${JwtService.getToken()}`,
      Accept: `application/json`,
    };

    return axios.post(baseUrl + `${resource}`, params);
  }

  public static delete(
    resource: string,
    params: AxiosRequestConfig
  ): Promise<AxiosResponse> {
    axios.defaults.headers.common = {
      Authorization: `Bearer ${JwtService.getToken()}`,
      Accept: `application/json`,
    };

    return axios.delete(baseUrl + `${resource}`, params);
  }

  public static put(
    resource: string,
    params: AxiosRequestConfig
  ): Promise<AxiosResponse> {
    axios.defaults.headers.common = {
      Authorization: `Bearer ${JwtService.getToken()}`,
      Accept: `application/json`,
    };
    return axios.put(baseUrl + `${resource}`, params);
  }

  public static setHeaders(token) {
    axios.defaults.headers.common = {
      Authorization: `Bearer ${JwtService.getToken()}`,
      Accept: `application/json`,
    };
  }

   
}

// export class ServerCall {
//   constructor() {
//     axios.defaults.headers.common["Authorization"] = `Token ${JwtService.getToken()}`;
//     axios.defaults.headers.common["Accept"] = "application/json";
//   }

//   /**
//    * @description send the GET HTTP request
//    * @param resource: string
//    * @param params: AxiosRequestConfig
//    * @returns Promise<AxiosResponse>
//    */
//    public static query(
//     resource: string,
//     params: AxiosRequestConfig
//   ): Promise<AxiosResponse> {
//     return axios.get(resource, params);
//   }

//   /**
//    * @description send the GET HTTP request
//    * @param resource: string
//    * @param slug: string
//    * @returns Promise<AxiosResponse>
//    */
//   public static get(
//     resource: string,
//     slug = "" as string
//   ): Promise<AxiosResponse> {
//     return axios.get(`${resource}/${slug}`);
//   }

//   /**
//    * @description set the POST HTTP request
//    * @param resource: string
//    * @param params: AxiosRequestConfig
//    * @returns Promise<AxiosResponse>
//    */
//   public static post(
//     resource: string,
//     params: AxiosRequestConfig
//   ): Promise<AxiosResponse> {
//     return axios.post(`${resource}`, params);
//   }

//   /**
//    * @description send the UPDATE HTTP request
//    * @param resource: string
//    * @param slug: string
//    * @param params: AxiosRequestConfig
//    * @returns Promise<AxiosResponse>
//    */
//   public static update(
//     resource: string,
//     slug: string,
//     params: AxiosRequestConfig
//   ): Promise<AxiosResponse> {
//     return axios.put(`${resource}/${slug}`, params);
//   }

//   /**
//    * @description Send the PUT HTTP request
//    * @param resource: string
//    * @param params: AxiosRequestConfig
//    * @returns Promise<AxiosResponse>
//    */
//   public static put(
//     resource: string,
//     params: AxiosRequestConfig
//   ): Promise<AxiosResponse> {
//     return axios.put(`${resource}`, params);
//   }

//   /**
//    * @description Send the DELETE HTTP request
//    * @param resource: string
//    * @returns Promise<AxiosResponse>
//    */
//   public static delete(resource: string): Promise<AxiosResponse> {
//     return axios.delete(resource);
//   }
// }
