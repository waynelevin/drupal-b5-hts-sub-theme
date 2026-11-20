// Builds one stylesheet per Bootswatch theme (css/bootswatch/NAME.css) for
// the "Bootswatch theme" setting, plus css/bootswatch/none.css (plain
// Bootstrap, no Bootswatch).
//
// Each variant is scss/style.scss with its Bootswatch imports pointed at
// another theme, so VSM's own variables and custom styles are kept. The
// default theme, Zephyr, uses css/style.css (built by `npm run build:css`),
// so it is not built here.
//
// Run: npm run build:bootswatch

import * as sass from 'sass';
import { existsSync, mkdirSync, readdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { pathToFileURL } from 'node:url';

const entry = 'scss/style.scss';
const source = readFileSync(entry, 'utf8');

// The Bootswatch Sass bundled with the Bootstrap 5 base theme.
const pattern = /(bootstrap5\/dist\/bootswatch\/[^/]+\/dist\/)zephyr\//g;
const match = source.match(/['"]([^'"]*bootstrap5\/dist\/bootswatch\/[^/]+\/dist\/)zephyr\/variables['"]/);
if (!match) {
  throw new Error(`${entry} no longer imports the Zephyr Bootswatch variables; update build-bootswatch.mjs.`);
}
const bootswatchDir = new URL(match[1], pathToFileURL(entry)).pathname;
const names = readdirSync(bootswatchDir)
  .filter((name) => name !== 'zephyr' && existsSync(`${bootswatchDir}/${name}/_variables.scss`))
  .sort();

const variants = Object.fromEntries(names.map((name) => [name, source.replace(pattern, `$1${name}/`)]));
// Plain Bootstrap: drop the two Bootswatch imports.
variants.none = source
  .split('\n')
  .filter((line) => !/@import\s+['"][^'"]*bootstrap5\/dist\/bootswatch\//.test(line))
  .join('\n');

rmSync('css/bootswatch', { recursive: true, force: true });
mkdirSync('css/bootswatch', { recursive: true });

for (const [name, scss] of Object.entries(variants)) {
  const result = sass.compileString(scss, {
    // Resolve the relative imports exactly as scss/style.scss does.
    url: pathToFileURL(entry),
    style: 'compressed',
    quietDeps: true,
    silenceDeprecations: ['import', 'global-builtin', 'color-functions', 'mixed-decls'],
  });
  writeFileSync(`css/bootswatch/${name}.css`, result.css);
  console.log(`css/bootswatch/${name}.css`);
}
