# WordPress starter theme developed by lillehummer

## Style guide

### CSS

- BEM style class names.

### JS

- StandardJS.

## Tooling

### Development

`yarn start` - Will run Browsersync with Webpack middleware for HMR.
`gulp images` - Optimises images from /src/img using the Kraken API and outputs result to /img.

### Production

`yarn production` - Produces CSS/JS files with hash in filenames and creates manifest.json with references.
