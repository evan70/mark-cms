# Accessibility Documentation

This document outlines the accessibility features and improvements implemented in the application to ensure it's usable by people with disabilities.

## Implemented Accessibility Features

### SEO and Metadata

#### Meta Description and Keywords (2024-12-17)
- Added meta description to all pages for better SEO and screen reader information
- Added meta keywords to all pages for better SEO
- Updated BaseController to automatically generate meta description and keywords from page title

```php
// BaseController.php - Automatically adding meta description and keywords
protected function render(Response $response, Request $request, string $template, array $data = []): Response
{
    // Add meta description and keywords if not provided
    if (!isset($data['metaDescription']) && isset($data['title'])) {
        $data['metaDescription'] = $data['title'] . ' - ' . config('app.description');
    }

    if (!isset($data['metaKeywords']) && isset($data['title'])) {
        // Add title keywords to default keywords
        $titleWords = preg_replace('/[^a-zA-Z0-9\s]/', '', $data['title']);
        $titleKeywords = strtolower(str_replace(' ', ', ', $titleWords));
        $data['metaKeywords'] = $titleKeywords . ', ' . config('app.meta_keywords');
    }

    // Rest of the method...
}
```

### Links and Navigation

#### Descriptive Link Text (2024-12-17)
- Added proper title and aria-label attributes to article links
- Ensured all links have descriptive text for screen readers
- Created article-link component for consistent and accessible article links

```html
<!-- Before: Link without descriptive text -->
<a href="/en/article/web-development-best-practices">
    Read More
</a>

<!-- After: Link with descriptive text -->
<a href="/en/article/web-development-best-practices"
   title="Web Development Best Practices"
   aria-label="Read article: Web Development Best Practices">
    Read More
</a>
```

### Color and Contrast

#### Improved Text Contrast (2024-12-17)
- Added custom gray color variants with better contrast ratios in Tailwind configuration
- Updated text colors throughout the site to meet WCAG 2.1 AA contrast requirements
- Fixed low-contrast text on dark backgrounds

```js
// Custom accessible color variants in tailwind.config.js
colors: {
    // ...
    // Accessible color variants with better contrast
    'gray': {
        150: '#eaeaea',  // Very light gray for dark backgrounds
        250: '#d1d1d1',  // Light gray with better contrast on dark
        350: '#b8b8b8',  // Medium light gray with good contrast
        450: '#9e9e9e',  // Medium gray with acceptable contrast
    },
}
```

Before and after examples:

```html
<!-- Before: Low contrast text -->
<p class="text-gray-400">Text with insufficient contrast</p>

<!-- After: Improved contrast text -->
<p class="text-gray-250">Text with better contrast</p>
```

### Navigation and Controls

#### Mobile Menu Button (2024-12-17)
- Added proper ARIA attributes to the mobile menu button:
  - `aria-label="Toggle mobile menu"` - Provides a descriptive name for screen readers
  - `aria-expanded="false/true"` - Dynamically indicates the state of the menu
  - `aria-controls="mobile-menu"` - Associates the button with the menu it controls
  - Added `aria-hidden="true"` to SVG icons to prevent screen readers from announcing them

```html
<!-- Before -->
<button class="md:hidden" id="mobile-menu-button">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
    </svg>
</button>

<!-- After -->
<button class="md:hidden" id="mobile-menu-button" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
    </svg>
</button>
```

JavaScript was also updated to toggle the `aria-expanded` attribute when the menu is opened/closed:

```javascript
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const isExpanded = mobileMenu.classList.contains('hidden') ? false : true;

    // Toggle the menu visibility
    mobileMenu.classList.toggle('hidden');

    // Update the aria-expanded attribute
    this.setAttribute('aria-expanded', !isExpanded);
});
```

### Document Structure

#### HTML Lang Attribute (2024-12-17)
- Ensured all HTML documents have a proper `lang` attribute to help screen readers use the correct pronunciation
- Added missing lang attribute to the 500 error page:

```html
<!-- Before -->
<html>

<!-- After -->
<html lang="{{ $language ?? config('app.default_language', 'en') }}">
```

- Fixed empty lang attribute in main layout by adding a default language fallback:

```html
<!-- Before -->
<html lang="{{ $language }}">

<!-- After -->
<html lang="{{ $language ?? config('app.default_language', 'sk') }}">
```

- Updated LanguageMiddleware to always set a default language when none is specified in URL:

```php
// Before - could result in empty language attribute
$lang = $pathParts[0] ?? '';
// ...
return $handler->handle($request->withAttribute('language', $lang));

// After - ensures a default language is always set
$lang = $pathParts[0] ?? '';
// ...
if ($lang === '') {
    $lang = $this->defaultLanguage;
}
return $handler->handle($request->withAttribute('language', $lang));
```

## Accessibility Testing

### Automated Testing Tools
- Lighthouse in Chrome DevTools
- axe DevTools browser extension

### Manual Testing
- Keyboard navigation testing
- Screen reader testing with:
  - NVDA on Windows
  - VoiceOver on macOS
  - TalkBack on Android

## Future Accessibility Improvements

- [ ] Add skip navigation links
- [ ] Ensure proper color contrast throughout the application
- [ ] Add focus styles for keyboard navigation
- [ ] Ensure all form elements have associated labels
- [ ] Add ARIA landmarks for major page sections

## Resources

- [Web Content Accessibility Guidelines (WCAG) 2.1](https://www.w3.org/TR/WCAG21/)
- [WAI-ARIA Authoring Practices](https://www.w3.org/TR/wai-aria-practices-1.1/)
- [MDN Web Docs: ARIA](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA)
