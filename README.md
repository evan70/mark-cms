# Mark CMS

Mark CMS je moderný, ľahký a flexibilný systém na správu obsahu (CMS) postavený na PHP s využitím Slim frameworku, Blade šablónovacieho systému a Tailwind CSS.

## Funkcie

- **Viacjazyčnosť** - Plná podpora pre viacjazyčný obsah
- **Responzívny dizajn** - Optimalizované pre všetky zariadenia vďaka Tailwind CSS
- **Moderná architektúra** - Postavené na Slim 4 frameworku s čistou architektúrou
- **Blade šablóny** - Intuitívny šablónovací systém z Laravel ekosystému
- **SEO optimalizácia** - Integrované nástroje pre lepšiu viditeľnosť vo vyhľadávačoch
- **Prístupnosť** - Implementované štandardy WCAG 2.1 pre lepšiu prístupnosť
- **Mark rozhranie** - Jednoduché a intuitívne rozhranie pre správu obsahu

## Požiadavky

- PHP 8.1 alebo vyšší
- Composer
- Node.js a NPM/PNPM pre frontend assets
- MySQL 5.7+ alebo MariaDB 10.3+

## Inštalácia

1. Klonujte repozitár:
   ```bash
   git clone https://github.com/evan70/mark-cms.git
   cd mark-cms
   ```

2. Nainštalujte PHP závislosti:
   ```bash
   composer install
   ```

3. Nainštalujte frontend závislosti:
   ```bash
   pnpm install
   # alebo
   npm install
   ```

4. Skopírujte `.env.example` do `.env` a nastavte prístupové údaje k databáze:
   ```bash
   cp .env.example .env
   ```

5. Vytvorte databázu a spustite inicializačnú migráciu:
   ```bash
   php bin/db-init
   ```

   Alebo resetujte databázu (drop a recreate):
   ```bash
   php bin/console db:reset
   ```

6. Spustite vývojový server:
   ```bash
   php -S localhost:8000 -t public
   ```

7. Skompilujte frontend assets:
   ```bash
   pnpm run dev
   # alebo
   npm run dev
   ```

## Vývoj

### Dokumentácia

Podrobná dokumentácia je dostupná v adresári `docs`:

- [Architektúra](docs/ARCHITECTURE.md) - Detailný popis architektúry systému
- [Prístupnosť](docs/ACCESSIBILITY.md) - Implementácia štandardov prístupnosti
- [Autorizácia](docs/AUTHORIZATION.md) - Systém autorizácie a prístupových práv
- [Layouty](docs/LAYOUTS.md) - Dostupné layouty a ich používanie
- [API](docs/API.md) - Dokumentácia REST API
- [API Autentifikácia](docs/API_AUTHENTICATION.md) - Autentifikácia pre REST API
- [Vývoj](docs/DEVELOPMENT.md) - Informácie pre vývojárov
- [Jazykové smerovanie](docs/LANGUAGE_ROUTING.md) - Implementácia viacjazyčnosti
- [Changelog](CHANGELOG.md) - Záznam zmien v projekte

### Štruktúra projektu

```
mark-cms/
├── app/                  # Aplikačný kód
│   ├── Controllers/      # Kontroléry
│   ├── Middleware/       # Middleware
│   ├── Models/           # Modely
│   └── Services/         # Služby
├── config/               # Konfiguračné súbory
├── database/             # Migrácie a seedery
│   ├── migrations/       # Migračné súbory
│   └── seeders/          # Seedery pre naplnenie databázy
├── docs/                 # Dokumentácia
│   └── articles/         # Články v Markdown formáte
├── public/               # Verejný adresár
├── resources/            # Frontend zdroje
│   ├── js/               # JavaScript súbory
│   ├── css/              # CSS súbory
│   └── views/            # Blade šablóny
├── routes/               # Definície ciest
└── storage/              # Úložisko pre cache, logy, atď.
```

### Vymazanie cache

Počas vývoja môžete potrebovať vymazať cache:

```bash
./clear-cache.sh
```

## Prispievanie

Príspevky sú vítané! Prosím, postupujte podľa týchto krokov:

1. Vytvorte fork repozitára
2. Vytvorte feature branch (`git checkout -b feature/amazing-feature`)
3. Commitnite vaše zmeny (`git commit -m 'Add some amazing feature'`)
4. Pushnite branch (`git push origin feature/amazing-feature`)
5. Otvorte Pull Request

## Licencia

Tento projekt je licencovaný pod [MIT licenciou](LICENSE).

## Kontakt

Evan - [GitHub](https://github.com/evan70)

Odkaz na projekt: [https://github.com/evan70/mark-cms](https://github.com/evan70/mark-cms)
