import axios from 'axios';


 /**
         * @param {String} tipo
         * @param {String} method
         * @param {Object} data
         * @param {String|null} urbBaseByUrl
         * @param {Object|null} objAdd
         * @param {Boolean} responseTypeBlob
         */
 export async function ApiCall(url: string, method: string, data: any) {
    method = method.toLowerCase();
    if (method != 'get' && method != 'post' && method != 'put' && method != 'delete') {
        throw new Error('Invalid method');
    }

    try {
        return await axios(url, {
            method: method,
            data: data,
        });
    } catch (error) {
        throw error;
    }
}