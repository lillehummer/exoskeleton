'use strict'

import '../css/styles.scss'
import '../css/login.scss'

if (module.hot) {
  module.hot.accept()
}

import $ from 'jquery'
// import Vue from 'vue'
// import modernizr from 'modernizr'
// import _ from 'lodash/fp'
// import is from 'is_js'

import global from './components/global'
// import replaceSvg from './components/replace-svg'

global.init()
// replaceSvg.init()
