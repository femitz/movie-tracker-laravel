import axios from 'axios';
import { GoogleGenAI } from "@google/genai";

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

export async function GeminiCall(prompt: string) {

    try {
        const api_key = import.meta.env.VITE_GEMINI_API;

        const ai = new GoogleGenAI({apiKey: api_key});
        const response = await ai.models.generateContent({
            model: "gemini-2.5-flash",
            contents: prompt,
        });
        return response.text;
    }
    catch (error) {}
}