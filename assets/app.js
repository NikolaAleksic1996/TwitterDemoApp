/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// import ReactDom from 'react-dom';
import React from 'react';
import {render} from 'react-dom';
import LogApp from './components/RepLog/LogApp';

const shouldShowHeart = true;


render(
    <div>
        <LogApp withHeart={shouldShowHeart} />
        <LogApp withHeart={false} />
    </div>,
    document.getElementById('lift-stuff-app')
);


// const el = React.createElement(
//     'h2',
//     null,
//     'Hello from react',
//     React.createElement('span', null, ' Heart')
// );
