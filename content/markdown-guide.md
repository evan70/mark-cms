---
title: 'Markdown prievodca'
slug: markdown-handbook
date: '2025-10-07'
author: 'Evan McDan'
categories:
    - blog
    - blog/technology/ai
tags:
    - taa
    - ' mee'
featured_image: /uploads/images/73cb999eab8c1d75.jpg
excerpt: "Markdown is a lightweight markup language that you can use to add formatting elements to plaintext text documents. Created by John Gruber in 2004, Markdown is now one of the world's most popular markup languages."
status: published
language: sk
is_index: false
---

# Markdown Guide

Markdown is a lightweight markup language that you can use to add formatting elements to plaintext text documents. Created by John Gruber in 2004, Markdown is now one of the world's most popular markup languages.

## Basic Syntax

These are the elements outlined in John Gruber's original design document.

### Headings

To create a heading, add number signs (#) in front of a word or phrase. The number of number signs you use should correspond to the heading level.

```
# Heading level 1
## Heading level 2
### Heading level 3
```

### Emphasis

You can add emphasis by making text bold or italic.

**Bold**
To bold text, add two asterisks or underscores before and after a word or phrase.

```
**bold text**
__bold text__
```

*Italic*
To italicize text, add one asterisk or underscore before and after a word or phrase.

```
*italicized text*
_italicized text_
```

### Lists

You can organize items into ordered and unordered lists.

**Ordered Lists**
To create an ordered list, add line items with numbers followed by periods.

```
1. First item
2. Second item
3. Third item
```

**Unordered Lists**
To create an unordered list, add dashes (-), asterisks (*), or plus signs (+) in front of line items.

```
- First item
- Second item
- Third item
```

### Links

To create a link, enclose the link text in brackets and then follow it immediately with the URL in parentheses.

```
[title](https://www.example.com)
```

### Images

To add an image, add an exclamation mark (!), followed by alt text in brackets, and the path or URL to the image asset in parentheses.

```
![alt text](image.jpg)
```

### Blockquotes

To create a blockquote, add a > in front of a paragraph.

```
> blockquote
```

### Code

To denote a word or phrase as code, enclose it in backticks (`).

```
`code`
```

### Horizontal Rules

To create a horizontal rule, use three or more asterisks (***), dashes (---), or underscores (___) on a line by themselves.

```
---
```

## Extended Syntax

These elements extend the basic syntax by adding additional features.

### Tables

To add a table, use three or more hyphens (---) to create each column's header, and use pipes (|) to separate each column.

```
| Syntax | Description |
| ------ | ----------- |
| Header | Title |
| Paragraph | Text |
```

### Fenced Code Blocks

To create fenced code blocks, use triple backticks (```) before and after the code block.

```
```
{
  "firstName": "John",
  "lastName": "Smith",
  "age": 25
}
```
```

### Footnotes

Footnotes allow you to add notes and references without cluttering the body of the document.

```
Here's a sentence with a footnote. [^1]

[^1]: This is the footnote.
```

### Heading IDs

You can link to headings with custom IDs in the document.

```
### My Great Heading {#custom-id}
```

### Definition Lists

Some Markdown processors allow you to create definition lists.

```
term
: definition
```

### Strikethrough

You can "strike through" words by putting a horizontal line through the center of them.

```
~~The world is flat.~~
```

### Task Lists

Task lists allow you to create a list of items with checkboxes.

```
- [x] Write the press release
- [ ] Update the website
- [ ] Contact the media
```

### Emoji

You can add emoji to your writing by typing `:EMOJICODE:`.

```
:smile:
```

### Highlight

You can highlight text by wrapping it with two equal signs.

```
I need to highlight these ==very important words==.
```

### Subscript

You can add subscript text by wrapping it with one tilde.

```
H~2~O
```

### Superscript

You can add superscript text by wrapping it with one caret.

```
X^2^
```

## Conclusion

Markdown is a versatile and easy-to-use markup language that can be used for a variety of purposes, from creating simple documents to building complex websites. With its simple syntax and wide adoption, it's a great choice for content creation.
