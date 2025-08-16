import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function getListToSelect(list: any[]) {
    return list.map((item) => ({
        name: item.name,
        value: item.id,
    }));
}

 /**
 * @param {String} date
 * @return {String}
 * @description Formata a data de um formato de banco de dados para um formato de data brasileiro
 * @example
 * formatDateFromDB("2025-08-16T00:00:00.000000Z") // "16/08/2025"
 * formatDateFromDB("2025-08-16") // "16/08/2025"
 * formatDateFromDB("16/08/2025") // "16/08/2025"
 */
export function formatDateFromDB(date: string) {
    if (date == null || date == undefined) {
            return "";
    }
    if (date == "") {
            return "";
    }
    //mes dia e ano
    var sep = " ";
    if (date.toString().indexOf("T") > -1) {
            sep = "T";
    }
    var arp = date.toString().split(sep);

    var ar = arp[0].split("-");
    return ar[2] + "/" + ar[1] + "/" + ar[0];
}