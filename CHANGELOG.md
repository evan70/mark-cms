# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- New accessibility documentation in `docs/ACCESSIBILITY.md`
- Reference to accessibility documentation in main README
- Added meta description to all pages for better SEO
- Added meta keywords to all pages for better SEO
- Created article-link component for consistent and accessible article links
- Added ArticleLinkService and article-link-v2 component for improved article link management
- Added article_link() helper function for easy generation of accessible article links
- Added cache clearing functionality for development
  - Modified BladeService to force recompile templates in development mode
  - Added clearCache() method to BladeService
  - Created clear-cache.php script and clear-cache.sh bash script

### Removed
- Removed unused `IlluminateContainerAdapter` class

### Fixed
- Accessibility: Added proper ARIA attributes to mobile menu button
  - Added `aria-label="Toggle mobile menu"` to provide a descriptive name for screen readers
  - Added `aria-expanded="false"` to indicate the initial state of the menu
  - Added `aria-controls="mobile-menu"` to associate the button with the menu it controls
  - Added `aria-hidden="true"` to the SVG icon to prevent screen readers from announcing it
  - Updated JavaScript to toggle the `aria-expanded` attribute when the menu is opened/closed
- Accessibility: Added missing lang attribute to the 500 error page
- Accessibility: Fixed empty lang attribute in main layout by adding default language fallback
- Accessibility: Updated LanguageMiddleware to always set a default language when none is specified in URL
- Accessibility: Improved text contrast throughout the site
  - Added custom gray color variants with better contrast ratios in Tailwind config
  - Updated footer text, language switcher, and various text elements to use higher contrast colors
  - Fixed low-contrast text in articles, home page, and components
- Accessibility: Added descriptive text to links
  - Added proper title and aria-label attributes to article links
  - Ensured all links have descriptive text for screen readers
- Fixed type safety issues in `getTranslation` methods in Article and Tag models
- Added proper variable checking in article-link component
- Fixed navigation animation issue that caused the nav element to jump on page load
- Updated `getTranslation` methods in Article and Tag models to always return null
- Fixed additional contrast issues with dates and text on dark backgrounds
- Improved contrast for service section headings and descriptions by using white text for headings and lighter gray for descriptions
- Improved 500 error page styling to match the 404 page for consistency
