'use strict';

import '../css/style.scss';
import '../css/login.scss';

if (module.hot) {
  module.hot.accept();
}

import $ from 'jquery';
// import Vue from 'vue';
// import modernizr from 'modernizr';

import app from './components/app';
import replaceSvg from './components/replace-svg';

app.init();
replaceSvg.init();
