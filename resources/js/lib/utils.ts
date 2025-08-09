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
