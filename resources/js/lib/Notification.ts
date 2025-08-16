import { toast, ToastType } from "vue3-toastify";
import "vue3-toastify/dist/index.css";


export function success(message: string) {
  toast(message, {
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    progress: undefined,
    theme: "light",
    type: "success",
    dangerouslyHTMLString: false,
  });
}

export function error(message: string) {
  toast(message, {
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    progress: undefined,
    theme: "light",
    type: "error",
    dangerouslyHTMLString: false,
  });
}

export function warning(message: string) {
  toast(message, {
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    progress: undefined,
    theme: "light",
    type: "warning",
    dangerouslyHTMLString: false,
  });
}

export function info(message: string) {
  toast(message, {
    position: "top-right",
    autoClose: 5000,
    hideProgressBar: false,
    closeOnClick: true,
    pauseOnHover: true,
    progress: undefined,
    theme: "light",
    type: "info",
    dangerouslyHTMLString: false,
  });
}