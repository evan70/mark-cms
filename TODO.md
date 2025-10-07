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
