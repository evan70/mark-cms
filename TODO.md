# TODO: Implement Default Language Without Prefix

## Completed Tasks
- [x] Modified LanguageMiddleware.php to not redirect invalid languages, set to default instead
- [x] Added get_language_prefix() helper function in app/helpers.php
- [x] Added routes for default language without {lang} prefix in routes/web.php
- [x] Updated all view files to use get_language_prefix($language) instead of /{{ $language }}/

## Next Steps
- [ ] Test the application to ensure URLs work correctly
- [ ] Verify that /articles loads Slovak content (default)
- [ ] Verify that /sk/articles also works
- [ ] Verify that /en/articles works for English
- [ ] Check for any remaining hardcoded /{{ $language }}/ links
- [x] Fix language switcher to redirect to current page instead of home
- [x] Implement session-based language persistence with switch route
- [x] Update navigation links to use current language prefix
- [x] Share language variable globally in BaseController for layout access
- [x] Fix Response constructor in LanguageMiddleware for redirects

## Refactoring Tasks
- [x] Create app/Services/ArticleService.php to handle article fetching and data preparation
- [x] Refactor ArticleController.php detail method to use ArticleService
- [x] Extract duplicated metadata setting logic in ContentService.php to a private setArticleMetadata method
- [x] Test refactored code to ensure article functionality works correctly
