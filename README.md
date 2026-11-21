# VSM theme

The Volunteer Shift Manager theme: a
[Bootstrap 5](https://www.drupal.org/project/bootstrap5) sub-theme. By default
it uses the Bootswatch **Zephyr** colour scheme and its font, Inter.

## Contents

- [Installation](#installation)
- [Theme settings](#theme-settings)
- [Icons](#icons)
- [Development](#development)
- [File structure](#file-structure)

## Installation

```bash
composer config repositories.vsm vcs https://github.com/waynelevin/drupal-b5-hts-sub-theme
composer require waynelevin/vsm:dev-main
drush theme:enable vsm
drush config:set system.theme default vsm -y
```

Composer installs the theme to `web/themes/custom/vsm` and pulls in the
Bootstrap 5 base theme. The compiled CSS (including all Bootswatch variants)
is committed in `css/`, so the theme works without running a build.

## Theme settings

Go to **Appearance → VSM → Settings** (`/admin/appearance/settings/vsm`). The
page has the Bootstrap 5 base theme's settings plus VSM's own, which are
marked *VSM* below. Each takes effect as soon as the form is saved.

| Section | Setting | From |
|---|---|---|
| Style | Bootswatch theme, Font | VSM |
| Tables | Striped tables, Row padding | VSM |
| Theme mode | Light or dark colour mode | Bootstrap 5 |
| Body options | Container width, body text and background colours | Bootstrap 5 |
| Navbar options | Navbar theme and background | Bootstrap 5 |
| Navbar options | Navbar menu alignment, Main menu icons | VSM |
| Footer options | Footer theme and background | Bootstrap 5 |

### Bootswatch theme *(VSM)*

Restyle the site with any of the 26 free [Bootswatch](https://bootswatch.com/)
themes, or **None** for plain Bootstrap. **Zephyr** is the default.

- Each option is a complete stylesheet built from `scss/style.scss` with that
  Bootswatch theme swapped in, so VSM's own variables and styles (table
  padding, navbar spacing and so on) are kept.
- Zephyr uses `css/style.css`; the others use `css/bootswatch/NAME.css`, built
  by `npm run build:bootswatch` (see [Development](#development)).
- The Bootswatch Sass comes from the Bootstrap 5 base theme
  (`dist/bootswatch/`), so the list matches the Bootswatch version it ships.
- The base theme's navbar and footer colours (eg *dark*, *primary*) use the
  selected theme's palette. Some themes' "dark" is quite light (Darkly's is
  light grey), so check those settings after switching.

### Font *(VSM)*

The font for body text, headings, buttons and the navbar:

- **Theme default** *(default)*: the selected Bootswatch theme's font, eg
  Inter for Zephyr, Lato for Darkly, or the system font stack for None.
- **System UI**: the device's native font. No web font is loaded.
- **Sans-serif**: Inter, Roboto, Open Sans, Lato, Montserrat, Poppins, Source
  Sans 3, Nunito, Raleway, Work Sans, DM Sans, IBM Plex Sans, Fira Sans,
  Manrope, Outfit.
- **Serif**: Merriweather, Lora, Playfair Display, PT Serif, Roboto Slab.

Web fonts load from Google Fonts in every weight the font offers, plus
italics where it has them; the browser only downloads the weights a page
uses. The font is applied by setting Bootstrap's `--bs-body-font-family`, so
it also reaches components that use that variable.

### Navbar menu alignment *(VSM)*

Where the menus sit in the top navbar: **Left**, **Centre** or **Right**
*(default)*. It applies on wide screens (992px and up); on smaller screens the
menus collapse behind the toggle button. It is in the base theme's **Navbar
options** section, next to the navbar colours.

### Main menu icons *(VSM)*

An icon before main menu links, from [Bootstrap Icons](#icons). One link per
line, as `path|icon`:

```
/node/3|house
/event-cards|calendar-event
/form/contact|envelope
```

- **Path**: the link's address. Either its alias (eg `/features`) or its
  internal path (eg `/node/3`) matches; use `/` for a link to the front page.
  It works for every kind of main menu link, including links that Views adds.
- **Icon**: a Bootstrap Icons name, without the `bi-` prefix. Browse them at
  [icons.getbootstrap.com](https://icons.getbootstrap.com/), or on the
  optional VSM style guide module's icons page.

Links that aren't listed have no icon, and lines that aren't in the
`path|icon` form are ignored. Icons in dropdown sub-menus work the same way.
The icons are hidden from screen readers, so each link is still read by its
title. Empty by default. It is in the base theme's **Navbar options**
section, under **Navbar menu alignment**.

### Tables *(VSM)*

Both settings apply to Drupal's tables on pages that use this theme (table
fields, forms and so on) and to Views tables. Admin pages use the admin theme,
so they are not affected.

**Striped tables**: when ticked, every other row is shaded with Bootstrap's
`table-striped` class. On by default, because the base theme always striped
Views tables. Tables whose rows turn striping off (`'no_striping' => TRUE`)
stay unstriped. VSM overrides the base theme's
`views-view-table.html.twig` so Views tables follow this setting.

**Row padding**: the space above and below the content of each row. Left and
right padding are unchanged (0.75rem).

| Option | Padding |
|---|---|
| **Theme default** *(default)* | The Bootswatch theme's own: 1rem for Zephyr, 0.75rem for Brite, 0.5rem for the others |
| **None** | 0 |
| **Compact** | 0.25rem (4px) |
| **Normal** | 0.5rem (8px), Bootstrap's default |
| **Comfortable** | 0.75rem (12px) |
| **Spacious** | 1rem (16px) |
| **Extra spacious** | 1.5rem (24px) |

Small tables (`table-sm`) keep their own compact padding.

### Settings reference

The settings are stored in `vsm.settings` with Drupal's other theme settings,
and can be exported with configuration management. VSM's own keys:

| Key | Default | Values |
|---|---|---|
| `bootswatch` | `zephyr` | A Bootswatch theme name, eg `darkly`, or `none` for plain Bootstrap |
| `font` | `''` | A font key from `includes/font.theme`, eg `lato`, `system`, or empty for the theme default |
| `navbar_alignment` | `right` | `left`, `center`, `right` |
| `menu_icons` | `''` | One `path\|icon` per line, eg `/event-cards\|calendar-event`, or empty for no icons |
| `table_striped` | `true` | `true` or `false` |
| `table_row_padding` | `''` | `none`, `compact`, `normal`, `comfortable`, `spacious`, `extra-spacious`, or empty for the theme default |

The base theme's keys (`b5_*`) are described in its own settings form.

> **Tip:** when setting a boolean with drush, use `1` or `0`:
> `drush config:set vsm.settings table_striped 0`. The word `false` is
> stored as "on".

## Icons

VSM loads [Bootstrap Icons](https://icons.getbootstrap.com/) on every page,
from its own copy in `icons/bootstrap-icons/` (version and update steps in
that folder's `README.md`). Use them in content or templates as
`<i class="bi bi-calendar-event"></i>`, and in the main menu with the
[Main menu icons](#main-menu-icons-vsm) setting.

## Development

### Setup

Install the build tools (Node.js 20 or later) from the theme folder:

```bash
npm install
```

### Building the CSS

| Command | Builds |
|---|---|
| `npm run build:css` | `css/style.css` (Zephyr) and `css/ck5style.css` (CKEditor 5 styles) |
| `npm run build:bootswatch` | `css/bootswatch/*.css`: every other Bootswatch theme, plus `none.css` (plain Bootstrap) |
| `npm run build` | Both |

All three use [Dart Sass](https://sass-lang.com/) and write minified CSS
without source maps. The older Laravel Mix setup (`webpack.mix.js`,
`npx mix`) does not run on current Node.js versions.

Run both after changing anything in `scss/`, and commit the updated `css/`
files: the Bootswatch variants are built from the same `scss/style.scss`, so
they go stale otherwise.

The Sass imports Bootstrap and Bootswatch from the Bootstrap 5 base theme at
`web/themes/contrib/bootstrap5`, so build inside a Drupal site that has it
installed.

## File structure

```
vsm/
├── config/
│   ├── install/vsm.settings.yml   Default settings
│   ├── optional/                  Default block placements
│   └── schema/vsm.schema.yml      Settings schema
├── css/                           Compiled CSS (committed)
│   ├── style.css                  Zephyr (default)
│   ├── ck5style.css               CKEditor 5 styles
│   └── bootswatch/                One stylesheet per other Bootswatch theme
├── icons/bootstrap-icons/         Bootstrap Icons font (loaded on every page)
├── includes/                      Settings logic
│   ├── bootswatch.theme           Bootswatch stylesheet switching
│   ├── font.theme                 Font setting
│   ├── menu_icons.theme           Main menu icons
│   ├── navbar.theme               Navbar menu alignment
│   └── table.theme                Striped tables and row padding
├── scss/                          Sass sources
├── templates/                     Twig template overrides
│   └── navigation/menu--main.html.twig  Main menu, with icons
├── build-bootswatch.mjs           Builds css/bootswatch/
├── theme-settings.php             Settings form
├── vsm.theme                      Hooks
└── webpack.mix.js                 Old Laravel Mix build (superseded by npm run build:css)
```
