# Changelog

Všetky významné zmeny v tomto projekte budú zdokumentované v tomto súbore.

Formát je založený na [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
a tento projekt dodržiava [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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

#### Opravené
- Problém s animáciou navigácie, ktorá spôsobovala posun prvku nav pri načítaní stránky (2025-04-03)
- Vylepšený štýl stránky 500, aby zodpovedal stránke 404 (2025-04-03)

### Odstránené
- Nepoužívaná trieda `IlluminateContainerAdapter` (2025-04-03)