# Changelog

Všetky významné zmeny v tomto projekte budú zdokumentované v tomto súbore.

Formát je založený na [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
a tento projekt dodržiava [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Zmeny v štruktúre projektu

#### Pridané
- Migrácia z `/admin` na `/mark` pre konzistentnú štruktúru projektu (2025-04-03)
  - Zmenené všetky cesty z `/admin` na `/mark`
  - Presunutié všetky šablóny z `admin/` do `mark/`
  - Aktualizované všetky kontroléry a middleware
  - Aktualizovaná dokumentácia

#### Opravené
- Opravená implementácia CSRF ochrany (2025-04-03)
  - Pridaný ResponseFactory pre CSRF Guard
  - Vytvorený SkipCsrfMiddleware pre preskočenie CSRF ochrany pre API cesty
  - Aktualizovaná funkcia csrf_fields() pre generáciu CSRF polí
  - Opravený problém s parametrom $storage v CSRF Guard
  - Použité vlastné pole ako úložisko pre CSRF tokeny namiesto session
- Opravený konflikt ciest (2025-04-03)
  - Upravená cesta `/{lang}` na `/{lang:[a-z]{2}}` pre obmedzenie na dvojznakové jazykové kódy
  - Odstránený konflikt s cestou `/login`
  - Zmenené poradie načítavania ciest, aby autentifikačné cesty boli načítané pred wildcard cestou
  - Odstránené duplicitné cesty pre `/mark/login`
  - Presunutié cesty pre prihlásenie z `/mark/login` na `/login`
  - Upravené presmerovanie na prihlasovací formulár
  - Pridané presmerovanie z domovskej stránky na `/mark` pre prihlásených používateľov
  - Upravený prihlasovací formulár pre rozlíšenie medzi bežnými používateľmi a mark_users
  - Upravený AuthController pre spracovanie prihlásenia pre oba typy používateľov
  - Upravený LanguageMiddleware, aby ignoroval určité cesty, ako napríklad `/mark`, `/login`, atď.
  - Opravený MarkAuthController, aby správne dedil od BaseController
  - Opravený AuthController, aby správne dedil od BaseController
  - Pridané načítavanie premenných prostredia z .env súboru
  - Odstránená závislosť na voku/html-min a nahradená jednoduchým HTML kompresorom
  - Opravený BladeService, aby nepoužíval neexistujúcu metódu forceRecompile()
  - Opravená funkcia csrf_fields(), aby nepoužívala neexistujúce metódy generateTokenName() a generateTokenValue()
  - Opravená konfigurácia CSRF ochrany, aby používala minimálne parametre a dostupné settery
- Upravená inicializačná migrácia (2025-04-03)
  - Pridané tabuľky pre používateľov a mark_users
  - Pridané spustenie seederov v rámci migrácie
  - Presunutié všetky seedery do adresára database/seeders s namespace Database\Seeders
- Pridaná konfigurácia loggera (2025-04-03)
  - Pridaná definícia pre 'logger' v kontajneri
  - Vytvorený adresár pre logy
- Pridaný jednoduchý skript pre inicializáciu databázy (2025-04-03)
  - Vytvorený skript bin/db-init pre jednoduché spustenie inicializačnej migrácie
- Pridaná premenná APP_ENV do .env súboru pre správnu konfiguráciu session
- Opravená konfigurácia session (2025-04-03)
  - Nastavený správny názov session cookie podľa SESSION_NAME v .env
  - Explicitné nastavenie názvu session pred jej spustením
- Opravená registrácia kontrolérov v kontajneri (2025-04-03)
  - Pridané predanie kontajnera do konštruktora kontrolérov
  - Pridaná definícia pre 'session' v kontajneri
- Pridané helper funkcie (2025-04-03)
  - url() - Umožňuje generáciu URL v šablónach
  - request() - Poskytuje objekt požiadavky s metódou is() pre kontrolu aktuálnej cesty
  - now() - Vráti aktuálny dátum a čas vo formáte Y-m-d H:i:s
- Premenovanie adresára kontrolérov (2025-04-03)
  - Premenovanie adresára `app/Controllers/Admin` na `app/Controllers/Mark` pre konzistenciu kódu
  - Aktualizované importy v routes/mark.php
  - Aktualizovaná registrácia kontrolérov v kontajneri
  - Upravený DashboardController pre používanie BaseController
  - Upravená šablóna dashboard.blade.php pre používanie layouts/app.blade.php
  - Nastavená tmavá téma pre admin rozhranie
  - Upravené farby v tabuľkách a formulároch pre konzistentný vzhľad
  - Pridaná možnosť prepnutia medzi horným menu a bočným menu layoutom
  - Pridaná stránka nastavenia pre výber layoutu
  - Opravený spôsob prepnutia layoutu pomocou samostatných šablón pre každý layout
  - Pridaná cesta `/mark/logout` pre odhlásenie používateľov z Mark CMS
  - Opravené nastavenie názvu session cookie na `mark_session`
  - Opravená duplicitná definícia cesty `/mark/logout`
  - Presunutiá cesta `/mark/logout` mimo chránenej skupiny, aby bola dostupná aj pre neprihlasených používateľov
  - Opravené nastavenie názvu session cookie pomocou ini_set
  - Opravené presmerovanie po prihlásení na `/mark` namiesto `/mark/admin/dashboard`
  - Opravené duplicitné spustenie session v container.php a SessionMiddleware
  - Upravené poradie middleware, aby SessionMiddleware bolo pred CSRF middleware
  - Použité session ako úložisko pre CSRF Guard
  - Upravený SkipCsrfMiddleware, aby preskakoval CSRF kontrolu len pre určité cesty
  - Zmenená metóda pre odhlásenie z POST na GET
  - Upravené formuláre pre odhlásenie na používanie odkazov namiesto formulárov
  - Upravený SessionMiddleware, aby používal session_name() a session_start() s parametrami
  - Nastavený názov session cookie v public/index.php pred spustením aplikácie
  - Použité filter_var pre konverziu SESSION_SECURE_COOKIE na boolean
- Pridaný článok o umelej inteligencii (2025-04-03)
  - Vytvorený Markdown súbor docs/articles/ai-revolution.md
- Upravený .gitignore (2025-04-03)
  - Pridané ignorácia databázových súborov *.sqlite a *.sqlite-journal
- Aktualizovaná dokumentácia (2025-04-03)
  - Aktualizovaný README.md s informáciami o inicializácii databázy a štruktúre projektu
  - Aktualizovaná dokumentácia o autorizácii s aktuálnymi cestami
  - Pridaná dokumentácia o layoutoch a ich používaní
- Pridaná správa obsahu, kategórií a tagov do admin rozhrania (2025-04-03)
  - Implementovaná správa obsahu pomocou Markdown súborov v adresári `content`
  - Vytvorené služby `ContentService`, `MarkdownParser` a `FileManager` pre prácu s obsahom
  - Vytvorený kontrolér `ContentMarkController` pre správu obsahu
  - Pridaná registrácia služieb v konténeri
  - Vytvorený konfiguračný súbor pre obsah
  - Pridaná závislosť na balíku `league/commonmark` pre parsovanie Markdown
  - Pridaná závislosť na balíku `symfony/yaml` pre parsovanie YAML
  - Opravené volanie rodičovského konštruktora v `ContentMarkController`
  - Pridaná registrácia `ContentMarkController` v konténeri
  - Implementovaná adresárová štruktúra pre obsah podľa vzoru PicoCMS
  - Upravené služby a kontroléry pre prácu s adresárovou štruktúrou
  - Upravené šablóny pre zobrazenie adresárovej štruktúry
  - Pridaný výber existujúcich kategórií vo formulári pre vytvorenie a úpravu článku (2025-04-04)
  - Opravené získavanie cesty k adresáru s obsahom
  - Pridané hardcoded kategórie pre testovanie
  - Pridané debug výpisy pre lepšiu diagnostiku
  - Upravené šablóny pre side-menu layout
  - Zabezpečené, že vždy budú k dispozícii aspoň nejaké kategórie

- Implementované automatické generovanie obsahu pomocou AI (2025-04-05)
  - Pridaná integrácia s OpenAI API
  - Vytvorená služba `AIContentGenerator` pre generovanie obsahu pomocou AI
  - Vytvorený kontrolér `AIContentController` pre generovanie obsahu
  - Vytvorené šablóny pre generovanie obsahu
  - Pridaná možnosť použiť vygenerovaný obsah pri vytváraní nového článku
  - Opravené spracovanie JSON odpovede z API
  - Pridané lepšie ošetrenie chýb
  - Opravená CSRF ochrana pri generovaní obsahu
  - Opravená redeklarácia premennej formData v JavaScript kóde
  - Opravené získavanie CSRF tokenu z formulára
  - Zmenený spôsob odosielania formulára z AJAX na tradičný formulár
  - Pridaný falošný generátor obsahu pre použitie bez OpenAI API
  - Implementovaný výber medzi rôznymi generátormi obsahu (OpenAI, Deepseek, Fake Generator)
  - Vytvorené rozhranie ContentGeneratorInterface pre jednotný prístup ku generátorom obsahu
  - Pridaná továrenská trieda ContentGeneratorFactory pre vytváranie generátorov obsahu
  - Vytvorené šablóny pre správu obsahu
  - Pridané cesty pre správu obsahu
  - Aktualizovaná navigácia v admin rozhraní

### Autorizácia

#### Pridané
- Implementovaný systém autorizácie pre bežných používateľov a mark_users (2025-04-03)
  - Vytvorené modely `User` a `MarkUser`
  - Vytvorené autentifikačné služby `AuthService` a `MarkAuthService`
  - Vytvorené middleware `UserAuthMiddleware` a `MarkAuthMiddleware`
  - Vytvorené kontroléry pre autentifikáciu a správu používateľov
  - Vytvorené šablóny pre prihlasovanie a správu používateľov

## [0.2.0] - 2025-04-03

### Prístupnosť a SEO

#### Pridané
- Nová dokumentácia o prístupnosti v `docs/ACCESSIBILITY.md` (2025-04-03)
- Odkaz na dokumentáciu o prístupnosti v hlavnom README (2025-04-03)
- Meta description pre všetky stránky pre lepšie SEO (2025-04-03)
- Meta keywords pre všetky stránky pre lepšie SEO (2025-04-03)

#### Opravené
- ARIA atribúty pre tlačidlo mobilného menu (2025-04-03)
  - Pridaný `aria-label="Toggle mobile menu"` pre popisný názov pre čítačky obrazovky
  - Pridaný `aria-expanded="false"` pre indikáciu počiatočného stavu menu
  - Pridaný `aria-controls="mobile-menu"` pre asociáciu tlačidla s menu
  - Pridaný `aria-hidden="true"` pre SVG ikonu
  - Aktualizovaný JavaScript pre prepínanie atribútu `aria-expanded`
- Chýbajúci lang atribút na stránke 500 (2025-04-03)
- Prázdny lang atribút v hlavnom layoute pridaním predvoleného jazyka (2025-04-03)
- Aktualizovaný LanguageMiddleware pre nastavenie predvoleného jazyka (2025-04-03)
- Zlepšený kontrast textu v celej aplikácii (2025-04-03)
  - Pridané vlastné varianty šedej farby s lepším kontrastom v Tailwind konfigurácii
  - Aktualizovaný text v pätičke, prepínač jazykov a rôzne textové prvky
  - Opravený nízky kontrast textu v článkoch, domovskej stránke a komponentoch
  - Použitý biely text pre nadpisy na tmavom pozadí pre maximálny kontrast
  - Použitá svetlejšia šedá (text-gray-150) pre popisný text na tmavom pozadí
- Pridaný popisný text k odkazom (2025-04-03)
  - Pridané atribúty title a aria-label k odkazom na články
  - Zabezpečené, že všetky odkazy majú popisný text pre čítačky obrazovky

### Komponenty a služby

#### Pridané
- Komponent article-link pre konzistentné a prístupné odkazy na články (2025-04-03)
- ArticleLinkService a komponent article-link-v2 pre lepšiu správu odkazov na články (2025-04-03)
- Helper funkcia article_link() pre jednoduché generovanie prístupných odkazov na články (2025-04-03)

#### Opravené
- Problémy s typovou bezpečnosťou v metódach `getTranslation` v modeloch Article a Tag (2025-04-03)
- Pridaná správna kontrola premenných v komponente article-link (2025-04-03)
- Aktualizované metódy `getTranslation` v modeloch Article a Tag, aby vždy vracali null (2025-04-03)

### Výkon a vývoj

#### Pridané
- Funkcionalita pre vymazanie cache počas vývoja (2025-04-03)
  - Upravený BladeService pre vynútené prekompilovanie šablón v režime vývoja
  - Pridaná metóda clearCache() do BladeService
  - Vytvorené skripty clear-cache.php a clear-cache.sh
- Presun inicializácie databázy do konfigurácie (2025-04-03)
  - Vytvorený konfiguračný súbor pre schému databázy
  - Vytvorená služba DatabaseInitializerService pre inicializáciu databázy
  - Pridaný konzolvý príkaz db:init pre inicializáciu databázy

#### Opravené
- Problém s animáciou navigácie, ktorá spôsobovala posun prvku nav pri načítaní stránky (2025-04-03)
- Vylepšený štýl stránky 500, aby zodpovedal stránke 404 (2025-04-03)

### Odstránené
- Nepoužívaná trieda `IlluminateContainerAdapter` (2025-04-03)