# 🎬 Sistema de Gerenciamento de Filmes

Um sistema moderno e completo para gerenciar sua coleção pessoal de filmes, desenvolvido com Laravel 12, Vue.js 3 e Inertia.js.

## ✨ Funcionalidades

- **Autenticação de Usuários**: Sistema completo de login, registro e verificação de email
- **Gerenciamento de Filmes**: CRUD completo para filmes pessoais
- **Categorização por Gêneros**: Organize seus filmes por gêneros cinematográficos
- **Interface Moderna**: UI responsiva e intuitiva com Tailwind CSS e componentes Vue
- **Exportação de Dados**: Download dos seus filmes em formato Excel (XLSX)
- **Dashboard Personalizado**: Visualize estatísticas da sua coleção
- **Sistema de Usuários**: Cada usuário tem sua própria coleção privada

## 🚀 Tecnologias Utilizadas

### Backend
- **Laravel 12** - Framework PHP moderno e robusto
- **PHP 8.2+** - Linguagem de programação
- **MySQL/SQLite** - Banco de dados
- **Inertia.js** - Bridge entre Laravel e Vue.js

### Frontend
- **Vue.js 3** - Framework JavaScript progressivo
- **TypeScript** - Superset do JavaScript com tipagem
- **Tailwind CSS 4** - Framework CSS utilitário
- **PrimeVue** - Biblioteca de componentes Vue
- **Reka UI** - Componentes de interface modernos

### Ferramentas de Desenvolvimento
- **Vite** - Build tool e dev server
- **ESLint + Prettier** - Linting e formatação de código
- **Pest** - Framework de testes PHP
- **Laravel Sail** - Ambiente Docker para desenvolvimento

## 📋 Pré-requisitos

- PHP 8.2 ou superior
- Composer 2.0 ou superior
- Node.js 18.0 ou superior
- NPM ou Yarn
- MySQL, PostgreSQL ou SQLite

## 🛠️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/femitz/movie-tracker-laravel.git
```

### 2. Instale as dependências PHP
```bash
composer install
```

### 3. Instale as dependências JavaScript
```bash
npm install
```

### 4. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure o banco de dados
Edite o arquivo `.env` com suas configurações de banco de dados:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies_db
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 6. Execute as migrações
```bash
php artisan migrate
```

### 7. Popule o banco com dados iniciais (opcional)
```bash
php artisan db:seed
```

### 8. Compile os assets
```bash
npm run build
```

### 9. Inicie o servidor
```bash
php artisan serve
```

## 🚀 Comandos de Desenvolvimento

### Desenvolvimento
```bash
# Inicia todos os serviços (servidor, filas, logs, Vite)
composer run dev

# Apenas o servidor Laravel
php artisan serve

# Apenas o Vite (hot reload)
npm run dev
```

### Build para Produção
```bash
# Build dos assets
npm run build

# Build com SSR
npm run build:ssr
```

## 📁 Estrutura do Projeto

```
movies/
├── app/
│   ├── Http/Controllers/     # Controladores da aplicação
│   ├── Models/              # Modelos Eloquent
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Migrações do banco
│   ├── seeders/            # Seeders para dados iniciais
│   └── factories/          # Factories para testes
├── resources/
│   ├── js/                 # Código JavaScript/Vue
│   │   ├── components/     # Componentes Vue reutilizáveis
│   │   ├── pages/          # Páginas da aplicação
│   │   └── layouts/        # Layouts da aplicação
│   └── css/                # Estilos CSS
├── routes/                  # Definições de rotas
└── tests/                   # Testes automatizados
```

## 🎯 Funcionalidades Principais

### Gerenciamento de Filmes
- **Criar**: Adicione novos filmes com nome, data e gêneros
- **Visualizar**: Lista organizada de todos os seus filmes
- **Editar**: Modifique informações dos filmes existentes
- **Excluir**: Remova filmes da sua coleção
- **Filtrar**: Organize por gêneros e datas

### Sistema de Gêneros
- Gêneros pré-definidos (Ação, Comédia, Drama, etc.)
- Múltiplos gêneros por filme
- Categorização inteligente

### Exportação de Dados
- Download da coleção em formato Excel
- Relatórios personalizados
- Backup dos seus dados

## 🔐 Autenticação

O sistema inclui:
- Registro de usuários
- Login/Logout
- Verificação de email
- Recuperação de senha
- Confirmação de senha
- Middleware de autenticação

## 🎨 Interface do Usuário

- **Design Responsivo**: Funciona em desktop, tablet e mobile
- **Tema Escuro/Claro**: Escolha sua preferência visual
- **Componentes Modernos**: Interface intuitiva e acessível
- **Navegação Intuitiva**: Sidebar e breadcrumbs para fácil navegação

## 📱 Páginas Principais

- **Dashboard**: Visão geral da sua coleção
- **Filmes**: Lista, criação, edição e exclusão
- **Configurações**: Perfil, senha e aparência
- **Autenticação**: Login, registro e recuperação de senha

## 🔧 Configurações

### Variáveis de Ambiente Importantes
```env
APP_NAME="Sistema de Filmes"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

## 🚀 Deploy

### Produção
1. Configure o ambiente de produção
2. Execute `npm run build`
3. Configure o servidor web (Apache/Nginx)
4. Configure as variáveis de ambiente
5. Execute `php artisan migrate --force`

## 📄 Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 🆘 Suporte

Se você encontrar algum problema ou tiver dúvidas:
- Abra uma issue no GitHub
- Consulte a documentação do Laravel
- Verifique os logs da aplicação

## 🙏 Agradecimentos

- [Laravel](https://laravel.com/) - Framework PHP
- [Vue.js](https://vuejs.org/) - Framework JavaScript
- [Inertia.js](https://inertiajs.com/) - Bridge Laravel-Vue
- [Tailwind CSS](https://tailwindcss.com/) - Framework CSS
- [PrimeVue](https://primevue.org/) - Componentes Vue

---

**Desenvolvido com ❤️ usando Laravel, Vue.js e Inertia.js**
