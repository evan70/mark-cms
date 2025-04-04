# Getting Started with Mark CMS

Welcome to Mark CMS, a modern content management system built with PHP and Slim Framework. This guide will help you get started with the system and show you how to create and manage content.

## Installation

To install Mark CMS, follow these steps:

1. Clone the repository: `git clone https://github.com/yourusername/mark-cms.git`
2. Navigate to the project directory: `cd mark-cms`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and configure your environment
5. Run the application: `php -S localhost:8000 -t public`

## Creating Content

Mark CMS uses Markdown files for content. To create a new article, simply create a new `.md` file in the `content` directory. The file should start with a title using the `#` syntax.

### Example Article

```markdown
# My First Article

This is my first article in Mark CMS. It's written in Markdown and supports all Markdown features.

## Subheading

You can use subheadings, **bold text**, *italic text*, and more.

- List item 1
- List item 2
- List item 3
```

## Managing Content

You can manage your content through the admin interface. To access the admin interface, go to `/mark` and log in with your credentials.

In the admin interface, you can:

- Create, edit, and delete articles
- Manage categories and tags
- Configure site settings
- Manage users and permissions

## Customizing the Theme

Mark CMS comes with a default theme, but you can customize it to match your brand. The theme files are located in the `resources/views` directory.

To customize the theme, you can:

1. Edit the Blade templates in `resources/views`
2. Modify the CSS in `resources/assets/css`
3. Add custom JavaScript in `resources/assets/js`

## Getting Help

If you need help with Mark CMS, you can:

- Check the documentation at `/docs`
- Join our community forum at [community.markcms.com](https://community.markcms.com)
- Open an issue on GitHub

We hope you enjoy using Mark CMS!
