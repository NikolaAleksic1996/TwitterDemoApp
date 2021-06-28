/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


import React from 'react';
import ReactDom from 'react-dom';

const el = React.createElement(
    'h2',
    null,
    'Hello from react',
    React.createElement('span', null, 'Heart')
);

ReactDom.render(el, document.getElementById('lift-stuff-app'));