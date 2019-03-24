# W3TC-Minify-Helper for Wordpress
Detects and loads CSS/JS scripts that require minification and render-blocking setup into W3TC

## What is it?
A plugin to be installed along-side W3 Total Cache, and to be run after installing and setup of it.

## What does it do?
Detects and loads the appropriate CSS/JS files into the W3TC configuration, so that they don't have to be added manually. It can also generate a list of the files so that you can manually add them.

## Why do I need it?
This is often a tedious process which I would rather have automated.

## How does it work?
Using the pagespeed insights API, it gathers all of the render-blocking resources, and adds these to W3TC
