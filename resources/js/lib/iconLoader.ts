import * as LucideIcons from 'lucide-vue-next';

export const getIcon = (iconName: string) => {
    const normalizedName = iconName.charAt(0).toUpperCase() + iconName.slice(1);
    
    const icon = (LucideIcons as any)[normalizedName];
    
    if (!icon) {
        console.warn(`Ícone "${iconName}" não encontrado. Usando ícone padrão.`);
        return LucideIcons.Circle;
    }
    
    return icon;
};

export const getAvailableIcons = () => {
    return Object.keys(LucideIcons).filter(key => 
        typeof (LucideIcons as any)[key] === 'function'
    );
};
