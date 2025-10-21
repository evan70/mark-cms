# TODO: Add Slug Helper Function

- [x] Add the `slug($string)` helper function to `app/helpers.php`
  - [x] Implement slug generation logic: convert to lowercase, replace spaces/special chars with hyphens, remove non-alphanumeric except hyphens, trim hyphens
  - [x] Wrap in `if (!function_exists('slug'))` check
  - [x] Place at the end of the file
- [x] Verify the function works as expected (e.g., test with sample inputs)
